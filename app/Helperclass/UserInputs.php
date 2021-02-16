<?php


namespace App\Helperclass;


use App\Exports\UsersExport;
use App\UserText;
use Exception;
use Illuminate\Support\Facades\DB;

class UserInputs
{

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
         * We need current time, as created_at and updated_at are not automatically set to records when using Model::insert()
         */
        $now = now();

        /**
         * Declare local function for multiple usage
         *
         * @param $name
         * @param $did
         * @param $type
         */
        $add = function($name, $did, $type) use($exportId, $fieldId, $userId, &$insertData, $now) {
            $insertData[] = [
                'user_id' => $userId,
                'field_id' => $fieldId,
                'danger_id' => $did,
                'export_id' => $exportId,
                'name' => $name,
                'created_at' => $now,
                'updated_at' => $now,
                'type' => $type,
            ];
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
            throw new Exception("Didn't happen to save user data. Try again later.");

        }

        return true;
    }

}
