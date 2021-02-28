<?php

namespace App\Helperclass;

use App\Export;
use App\UserText;
use Closure;
use Exception;
use Illuminate\Support\Facades\DB;

class UserInputs
{
    /**
     * This function takes record with $exportId from 'exports' table
     * Then, it iterates over the '$inputType' values and finds those which were added by users under '$dangerId' (having did = $dangerId)
     * And which have value - $name
     * These values are removed from export
     * and if everything went fine, 'success' is returned.
     *
     * @param int $exportId
     * @param int $dangerId
     * @param string $name
     * @param string $inputType
     * @return bool
     * @throws Exception
     */
    public static function filterExport(int $exportId, int $dangerId, string $name, string $inputType): bool
    {
        /**
         * Search Export and if it does not exist, this means author has already deleted it from database.
         * As a result, we return true.
         */
        $export = Export::find($exportId);
        if (!$export) {
            return true;
        }

        /**
         * Remember, data includes some extra info for showing form
         * The target information is set at index 0
         */
        $data = json_decode($export->data, true)[0];

        /**
         * Data filter
         *
         * @param $cur
         * @return bool
         */
        $filter = function ($cur) use($name) {
            if (!isset($cur['added'])) {
                /**
                 * This was not added by an user.
                 */
                return true;
            }

            /**
             * Values are formed in the following way:
             * [
             *    'model' => [
             *         'name' => [[$userInput]]
             *         ...
             *         ]
             * ]
             */
            if ($cur['model']['name'] === $name) {
                return false;
            }

            return true;
        };

        /**
         * We need to create custom array_filter, otherwise it leads to some unexpected behaviour...
         * instead of getting array keys , like - [0,1,2,3],  we may get [3, 5, 11 ...]
         * and that causes table rendering issues.
         *
         * @param array $array
         * @param Closure $fn
         * @return array
         */

        $array_filter = function (array $array, Closure $fn) {
            $res = [];
            foreach ($array as $item) {
                if ($fn($item)) {
                    $res[] = $item;
                }
            }
            return $res;
        };


        /**
         * Data is formed in [processId] => [[$dangerId]] way
         * So its an array of arrays
         */
        foreach ($data as $i => $process) {
            foreach ($process as $j => $danger){
                if (gettype($danger) !== 'array') {
                    /**
                     * This is also extra data, like max:*
                     */
                    continue;
                }

                if ($danger['did'] !== $dangerId) {
                    /**
                     * We should not delete userInputs that have $did other than $dangerId
                     */
                    continue;
                }

                /**
                 * Filter User Inputs.
                 *
                 * Controls have different format.
                 * they are divided into three groups.
                 * We should filter them differently.
                 */

                if ($inputType === 'control') {
                    foreach ([0, 1] as $type) {
                        $data[$i][$j]['data']['control'][$type] = $array_filter($data[$i][$j]['data']['control'][$type], $filter);
                    }
                } else {
                    $data[$i][$j]['data'][$inputType] = $array_filter($danger['data'][$inputType], $filter);
                }
            }
        }

        /**
         * Now we should convert current data format into another format, to recalculate risks
         *
         * Current format: [ 'pid' => [..], 'pid*' => [...], 'pid**' => [...] ]
         *
         * Target format: [ ['pid', ...],   ['pid*', ...], ['pid**', ...] ]
         */

        $targetData = [];

        foreach ($data as $p) {
            foreach ($p as $d) {
                if (gettype($d) !== 'array') {
                    /**
                     * It's an extra data, like - max:*
                     */
                    continue;
                }

                $targetData[] = [
                    'did' => $d['did'],
                    'pid' => $d['pid'],
                    'data' => $d['data'],
                    'processModel' => $d['processModel'],
                    'dangerModel' => $d['dangerModel'],
                    'dangerControlsSum' => $d['dangerControlsSum']
                ];
            }
        }

        /**
         * If everything is ok, then next step is to create finalData instance and call its' init method to make data well-formatted and do risks calculations.
         */
        $finalData = new FinalData($exportId, FinalData::RETURN_DATA);

        /**
         * Get final data.
         */
        $data = $finalData->init($targetData);

        /**
         * Convert data into json.
         */
        $data = json_encode($data);

        /**
         * Update export
         */
        $export->update(['data' => $data]);

        /**
         * Are we done ? Yes? ...ok
         */
        return true;
    }

    /**
     * Makes records in UserTexts table
     * These data will be shown in admin panel
     *
     * @param int $exportId
     * @param int $fieldId
     * @param array $userInputs
     * @return bool
     * @throws Exception
     */
    public static function createRecords(int $exportId, int $fieldId, array $userInputs): bool
    {
        /**
         * If this is an update , delete all previously added UserInputs
         */
        $userId = current_user()->id;

        /**
         * Take previous data that were added by an user and that are ignored by the admin
         */
        $previousData = UserText::where(['user_id' => $userId])
            ->where(['field_id' => $fieldId])
            ->where(['export_id' => $exportId])
            ->where(['is_ignored' => true])
            ->get();

        /**
         * Map $previousData
         */
        $globalMapper = [
            'control' => [],
            'ploss' => [],
            'udanger' => []
        ];

        foreach ($previousData as $datum) {
            $globalMapper[$datum->type][$datum->name] = true;
        }

        /**
         * Delete all of them
         */
        UserText::where(['user_id' => $userId])
            ->where(['field_id' => $fieldId])
            ->where(['export_id' => $exportId])
            ->delete();

        /**
         * Make records to database
         */

        DB::beginTransaction();

        /**
         * This includes all data that should be inserted in one request.
         */
        $insertData = [];

        /**
         * We need to manually set created_at and updated_at attributes to those records as they aren't automatically set when using Model::insert() method.
         */
        $now = now();

        /**
         * Declare local function for multiple usage
         * Set is_ignored to true if such user input exists in database
         *
         * @param $name
         * @param $did
         * @param $type
         */
        $add = function($name, $did, $type) use($exportId, $fieldId, $userId, &$insertData, $now, $globalMapper) {
            $row = [
                'user_id' => $userId,
                'field_id' => $fieldId,
                'danger_id' => $did,
                'export_id' => $exportId,
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
                'type' => $type,
                'is_ignored' => false,
            ];

            if (isset($globalMapper[$type][$name])) {
                $row['is_ignored'] = true;
            }

            $insertData[] = $row;
        };

        foreach ($userInputs as $did => $userInput) {
            foreach (['newControls' => 'control', 'newPloss' => 'ploss', 'newUdangers' => 'udanger'] as $cur => $type) {
                $mapper = [];
                foreach ($userInput[$cur] as $ui) {
                    if (!isset($mapper[$ui])) {
                        $mapper[$ui] = true;
                        $add($ui, $did, $type);
                    }
                }
            }
        }

        try {

            UserText::insert($insertData);
            DB::commit();

        } catch (Exception $exception) {

            DB::rollBack();
//            throw new Exception("Didn't happen to save user data. Try again later.");
            throw new Exception($exception->getMessage());
        }

        return true;
    }

}
