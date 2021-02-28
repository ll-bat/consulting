<?php

namespace App\Helperclass;

use App\Control;
use App\ControlDanger;
use App\Danger;
use App\DangerProcess;
use App\Ploss;
use App\Process;
use App\Udanger;
use App\UserText;
use Exception;
use Illuminate\Support\Facades\DB;

class Filter
{
    private $data;
    private int $fieldId;
    private $oldImages;
    private array $imageNameValidator = [];

    private array $addedValues = [];

    /**
     * Filter constructor.
     * @param $obj
     * @param $fieldId
     * @throws Exception
     */
    public function __construct($obj, $fieldId)
    {
        $this->fieldId = $fieldId;
        $this->oldImages = session()->get('_oldImages') ?? [];

        /**
         * Check if chosen [processes, dangers, controls, potential losses, udangers] are existent in database
         */
        $data = $this->filterData(
        /**
         * Check if value-types are valid: for example [pid,did] should be integers, [data] should be an array, [added inputs] should be strings, and so on..
         */
            $this->filterUserInputs(
            /**
             * Convert object of stdClass into array
             */
                $this->makeAssoc($obj)
            )
        );

        /**
         * Save all added inputs
         */
        $data = $this->saveAddedValues($data);

        /**
         * Check if each danger-page is completed. So, all required fields should be presented
         */
        $this->data = $this->checkPageCompletion($data);

        if (!$this->data) {
            throw new Exception('Please provide the data');
        }
    }

    /**
     * @return array|array[]
     */
    public function getAddedValues(): array
    {
        return $this->addedValues;
    }

    /**
     * This function appends user inputs to actual data attributes. Say, user added two potential losses(ploss),
     * if they pass validation tests, then we take them and append to data['ploss'] attribute to show them in the form
     * Also , we should make a record in UserTexts to notify admin that new 'type' has been added
     * Admin has three options: Add, Ignore, Delete
     * Add: Adds new 'type' to actual data, so it becomes available for all users.
     * Ignore: this 'type' remains in only current form and is not available for others.
     * Delete: this 'type' is deleted from current form and no one can see it.
     *
     * @param array $data
     * @return array
     */
    private function saveAddedValues(array $data): array
    {
        foreach ($data as $ind => &$d) {

            /**
             * We divide all added data by danger id and save in that format
             * When editing each danger, there should be corresponding form of these values at the very bottom of danger.
             */
            $did = $d['did'];
            if (!isset($this->addedValues[$did])) {
                $this->addedValues[$did] = [
                    'newControls' => [],
                    'newPloss' => [],
                    'newUdangers' => []
                ];
            }

            foreach ($d['data']['newUdangers'] as $newUdanger) {
                $d['data']['udanger'][] = [
                    'model' => ['name' => $newUdanger['value']],
                    'added' => true,
                ];
                $this->addedValues[$did]['newUdangers'][] = $newUdanger['value'];
            }

            foreach ($d['data']['newPloss'] as $newPloss) {
                $d['data']['ploss'][] = [
                    'model' => ['name' => $newPloss['value'], 'k' => Ploss::k],
                    'added' => true,
                ];
                $this->addedValues[$did]['newPloss'][] = $newPloss['value'];
            }

            foreach ($d['data']['newControls'] as $type => $controls) {
                $ind = $type === 'first' ? 0 : 1;

                foreach ($controls as $control) {
                    $d['data']['control'][$ind][] = [
                        'model' => ['name' => $control['value'], 'k' => Control::k, 'rploss' => 0],
                        'added' => true,
                    ];
                    $this->addedValues[$did]['newControls'][] = $control['value'];
                }
            }

            $d['data']['newControls'] = [];
            $d['data']['newPloss'] = [];
            $d['data']['newUdangers'] = [];

            /**
             * TODO: udangers are not recovered to correct state when editing form
             */
        }

        return $data;
    }

    /**
     * Converts object of stdClass into array
     *
     * @param $data
     * @return mixed
     */
    public function makeAssoc($data)
    {
        $obj = [];

        if (!in_array(gettype($data), ['array', 'object'])) {
            return $data;
        }

        foreach ($data as $ind => $d) {
            $obj[$ind] = $this->makeAssoc($d);
        }

        return $obj;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getImageRule(): array
    {
        return $this->imageNameValidator;
    }

    /**
     * @param $obj
     * @return array
     */
    public function filterUserInputs($obj): array
    {
        $returnData = [];
        foreach ($obj as $o) {
            try {
                $d = $this->filter($o);
                if (!$d) continue;
            } catch (\Throwable $e) {
                continue;
            }
            $returnData[] = $d;
        }

        return $returnData;
    }

    public function filter($o)
    {
        /**
         * Check variables and their values. If at least one variable has invalid type or value, ignore whole element...
         */

        $obj = [];
        $data = [];
        $false = false;

        /**
         * DangerId should be integer
         */

        if ($this->isInt($o['did'], '', $false)) {
            $obj['did'] = $o['did'];
        } else {
            return false;
        }


        /**
         * ProcessId should be integer
         */
        if ($this->isInt($o['pid'], '', $false)) {
            $obj['pid'] = $o['pid'];
        } else {
            return false;
        }

        list($pid, $did) = [$obj['pid'], $obj['did']];

        /**
         * Data should be array
         */
        if (gettype($o['data']) != 'array') {
            return false;
        }
        $o = $o['data'];

        /**
         * Filter image name and delete old one if necessary
         */
        if (gettype($o['hasImage']) != 'boolean') {
            return false;
        }
        $data['hasImage'] = $o['hasImage'];

        $hasOldImage = false;

        if (isset($this->oldImages[$pid]) && isset($this->oldImages[$pid][$did])) {
            $hasOldImage = true;
        }


        if ($data['hasImage']) {
            if ($this->filterImageName($o['imageName'], 'imageName', $pid, $did, $data)) {
                if ($hasOldImage) {
                    if (!session()->has('_docData')) {
                        // @TODO: Implement image deletion .
                    }
                }
                $this->imageNameValidator[$data['imageName']] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            } else {
                return false;
            }
        } else {
            if ($hasOldImage) {
                if (!isset($o['oldImage']) || !$o['oldImage']) {
                    if (!session()->has('_docData')) {
                        // @TODO: Implement old image deletion .
                    }
                    $data['hasImage'] = false;
                    $data['imageName'] = '';
                } else {
                    $data['hasImage'] = true;
                    $data['oldImage'] = true;
                    $data['imageName'] = $this->oldImages[$pid][$did];
                }
            }
        }

        /**
         * Divide controls into 3 types according to user answers
         */
        if (gettype($o['control']) != 'array') {
            return false;
        }

        /**
         * TODO: danger-completion validation is not implemented
         */

        $data['control'] = [[], [], [], []];
        foreach ($o['control'] as $c) {
            if (!isset($c['id']) || !isset($c['value'])) {
                continue;
            }
            if (!$this->isInt($c['id'], '', $false) || !$this->isInt($c['value'], '', $false)) {
                continue;
            }
            if (!in_array($c['value'], [0, 1, 2, 3])) continue;

            $data['control'][$c['value']][] = ['id' => $c['id'], 'value' => $c['value']];
        }

        /**
         * Filter ploss and udanger
         */
        $data['ploss'] = $data['udanger'] = [];

        foreach (['ploss', 'udanger'] as $type) {
            if (gettype($o[$type]) == 'array') {
                foreach ($o[$type] as $p) {
                    if (!isset($p['id']) || !isset($p['value'])) continue;
                    if (!$this->isInt($p['id'], '', $false) || !$this->isInt($p['value'], '', $false)) continue;
                    if ($p['value'] != 1) continue;
                    $data[$type][] = ['id' => $p['id'], 'value' => $p['value']];
                }
            }
        }

        /**
         * Filter input[type='text'] fields. Array keys are form names and values - validator functions
         */

        $data['newUdangers'] = $data['rpersons'] = $data['newPloss'] = [];

        $types = [
            'newUdangers' => 'isString',
            'rpersons' => 'isString',
            'newPloss' => 'isString'
        ];

        foreach ($types as $type => $filter) {
            $data[$type] = [];
            if (gettype($o[$type]) === 'array') {
                foreach ($o[$type] as $ind => $n) {
                    /**
                     * No more than 2 elements are allowed to add
                     */
                    if ($ind > 1) {
                        break;
                    };

                    if (isset($n['value'])) {
                        if (call_user_func([static::class, $filter], $n['value'])) {
                            if (mb_strlen($n['value']) < 550) {
                                $data[$type][] = ['value' => $n['value']];
                            }
                        }
                    }
                }
            }
        }

        /**
         * Filter added controls
         * there should be two different arrays with keys: first: [], second: []
         * each element in each type should be presented this way: ['value' => '...']
         */

        $newControls = [
            'first' => [],
            'second' => []
        ];

        foreach (['first', 'second'] as $type) {
            if (isset($o['newControls'][$type]) && gettype($o['newControls'][$type]) === 'array') {
                foreach ($o['newControls'][$type] as $ind => $cur) {
                    /**
                     * No more than 2 elements are allowed to add
                     */
                    if ($ind > 1) {
                        break;
                    }
                    if (isset($cur['value']) && $this->isString($cur['value'])) {
                        $newControls[$type][] = ['value' =>  $cur['value']];
                    }
                }
            }
        }

        $data['newControls'] = $newControls;

        /**
         * Filter added etimes
         * As above, there should be two different arrays with keys: normal: [], time: []
         * 'normal' has input[type='text'] format
         * 'time' has input[type='date'] format
         * array elements should be presented this way: ['value' => '...']
         */

        $etimes = [];
        $validators = [
            'normal' => 'isString',
            'time' => 'isDate'
        ];

        foreach ($validators as $type => $validator) {
            if (isset($o['etimes'][$type]) && gettype($o['etimes']) === 'array') {
                foreach ($o['etimes'][$type] as $ind => $cur) {
                    /**
                     * No more than 2 elements are allowed to add
                     */
                    if ($ind > 1) {
                        break;
                    }

                    if (isset($cur['value'])) {
                        if (call_user_func([static::class, $validator], $cur['value'])) {
                            $etimes[] = ['value' => $cur['value'], 'type' => $type];
                        }
                    }
                }
            }
        }

        $data['etimes'] = $etimes;

        /**
         * Set data to $obj and return that validated $obj
         */
        $obj['data'] = $data;

        return $obj;
    }

    /**
     *  Checks process, danger, control - ids. Omit whole element if such records does not exist in database
     * @param $data
     * @return array
     */
    public function filterData($data): array
    {
        $used = [];
        $processes = [];

        foreach ($data as $d) {
            $pid = $d['pid'];
            if (!isset($used[$pid])) {
                $used[$pid] = true;
                $processes[] = $pid;
            }
        }

        $processes = Process::whereIn('id', $processes)
            ->where('field_id', $this->fieldId)
            ->select('id', 'name')
            ->get()
            ->toArray();

        $processIds = [];
        foreach ($processes as $p) {
            $processIds[$p['id']] = $p['name'];
        }

        $dangers = [];
        $used = [];
        foreach ($data as $d) {
            [$pid, $did] = [$d['pid'], $d['did']];

            if (isset($processIds[$pid])) {
                if (!isset($used[$did])) {
                    $used[$did] = true;
                    $dangers[] = $did;
                }
            }
        }

        /**
         * We will need these dangers later, so we can set them already there
         */
        $allDangers = Danger::whereIn('id', $dangers)
            ->select('id', 'name', 'k')
            ->get()
            ->toArray();

        /**
         * Index them with id , as it makes search process fast
         */
        $dangersMap = [];
        foreach ($allDangers as $d) {
            $dangersMap[$d['id']] = ['name' => $d['name'], 'k' => $d['k']];
        }

        $procIds = [];
        foreach ($processes as $p) {
            $procIds[] = $p['id'];
        }

        $dangerProcesses = DangerProcess::whereIn('danger_id', $dangers)
            ->whereIn('process_id', $procIds)
            ->select('danger_id', 'process_id')
            ->get()
            ->toArray();

//        $dangerProcesses = DB::table('dangers')
//            ->join('danger_process', 'dangers.id', '=', 'danger_process.danger_id')
//            ->select('danger_process.danger_id', 'danger_process.process_id')
//            ->whereIn('danger_process.danger_id', $dangers)
//            ->whereIn('danger_process.process_id', $procIds)
//            ->get()
//            ->toArray();

//        dd($dangerProcesses);

        $dangerProcessIds = [];
        foreach ($dangerProcesses as $ind => $pair) {
            $dangerProcessIds[$pair['process_id']][$pair['danger_id']] = true;
        }

//        dd($dangerProcessIds);

        $controls = [];
        $potentialLoss = [];
        $underDanger = [];
        $used = [];
        $first = [];
        $second = [];
        foreach ($data as $ind => $d) {
            [$pid, $did] = [$d['pid'], $d['did']];

            if (isset($dangerProcessIds[$pid]) && isset($dangerProcessIds[$pid][$did])) {
                $_controls = $d['data']['control'];
                foreach ($_controls as $type) {
                    foreach ($type as $c) {
                        if (!isset($used[$c['id']])) {
                            $used[$c['id']] = true;
                            $controls[] = $c['id'];
                        }
                    }
                }
                foreach ($d['data']['ploss'] as $p) {
                    if (!isset($first[$p['id']])) {
                        $first[$p['id']] = true;
                        $potentialLoss[] = $p['id'];
                    }
                }
                foreach ($d['data']['udanger'] as $p) {
                    if (!isset($second[$p['id']])) {
                        $second[$p['id']] = true;
                        $underDanger[] = $p['id'];
                    }
                }
            }
        }

        $controlDangers = ControlDanger::whereIn('control_id', $controls)
            ->whereIn('danger_id', $dangers)
            ->select('danger_id', 'control_id')
            ->get()
            ->toArray();

//        $controlDangers = DB::table('controls')
//            ->join('control_dangers', 'control_dangers.control_id', '=', 'controls.id')
//            ->select('control_dangers.control_id', 'control_dangers.danger_id')
//            ->whereIn('control_dangers.control_id', $controls)
//            ->whereIn('control_dangers.danger_id', $dangers)
//            ->get()
//            ->toArray();

//        dd($controlDangers);

        $controlDangerIds = [];
        foreach ($controlDangers as $c) {
            $controlDangerIds[$c['danger_id']][$c['control_id']] = true;
        }

//        dd($controlDangerIds);

        $potentialLoss = Ploss::whereIn('id', $potentialLoss)
            ->where('field_id', $this->fieldId)
            ->select('id', 'name', 'k')
            ->get()
            ->toArray();

        $potentialLossIds = [];
        foreach ($potentialLoss as $p) {
            $potentialLossIds[$p['id']] = ['name' => $p['name'], 'k' => $p['k']];
        }

        $underDanger = Udanger::whereIn('id', $underDanger)
            ->where('field_id', $this->fieldId)
            ->select('id', 'name')
            ->get()
            ->toArray();

        $underDangerIds = [];
        foreach ($underDanger as $p) {
            $underDangerIds[$p['id']] = ['name' => $p['name']];
        }

        /**
         * Now we need to get all controls that match with user's checked control ids. We first iterate over all ids and create a set of them
         * finally we make a request to fetch all of them and then index them to search later quickly.
         */
        $allControls = [];
        $used = [];
        foreach ($data as $d) {
            [$pid, $did] = [$d['pid'], $d['did']];
            if (isset($dangerProcessIds[$pid]) && isset($dangerProcessIds[$pid][$did])) {
                foreach ($d['data']['control'] as $t) {
                    foreach ($t as $c) {
                        if (isset($controlDangerIds[$did]) && isset($controlDangerIds[$did][$c['id']])) {
                            if (!isset($used[$c['id']])) {
                                $used[$c['id']] = true;
                                $allControls[] = $c['id'];
                            }
                        }
                    }
                }
            }
        }
        $allControls = Control::whereIn('id', $allControls)
            ->select('id', 'name', 'k', 'rploss')
            ->get()
            ->toArray();

        $controlsMap = [];
        foreach ($allControls as $c) {
            $controlsMap[$c['id']] = ['name' => $c['name'], 'k' => $c['k'], 'rploss' => $c['rploss']];
        }
        /**
         * Use custom filter to pass elements by reference...
         *
         * @param $data
         * @param $fn
         * @return array
         */
        function filter($data, $fn): array
        {
            $result = [];
            foreach ($data as $d) {
                $ok = $fn($d);
                if ($ok) {
                    $result[] = $d;
                }
            }
            return $result;
        }

        /**
         *  Usage of high-order functions to filter user data;
         */
        $data = filter($data, function (&$d) use ($processIds, $dangerProcessIds, $controlDangerIds, $potentialLossIds, $underDangerIds, $dangersMap, $controlsMap) {
            [$pid, $did] = [$d['pid'], $d['did']];
            if (!isset($dangerProcessIds[$pid]) || !isset($dangerProcessIds[$pid][$did])) {
                return false;
            }

            // We will need that value later
            $d['processModel'] = ['name' => $processIds[$pid]];
            $d['dangerModel'] = $dangersMap[$did];
            /**
             * Controls are divided into 3 parts, so we iterate each of them separately and filter each properly
             */
            $d['data']['control'] = array_map(function ($type) use ($controlDangerIds, $did, $controlsMap) {
                return filter($type, function (&$c) use ($controlDangerIds, $did, $controlsMap) {
                    if (!isset($controlDangerIds[$did]) || !isset($controlDangerIds[$did][$c['id']])) {
                        return false;
                    }
                    $c['model'] = $controlsMap[$c['id']];
                    return true;
                });
            }, $d['data']['control']);

            /**
             * Ploss and udanger have same structure, we can combine these two loops into one, but to make it easier for understanding, we write them separately.
             */
            $d['data']['ploss'] = filter($d['data']['ploss'], function (&$p) use ($potentialLossIds) {
                $is = isset($potentialLossIds[$p['id']]);
                if ($is) {
                    $p['model'] = $potentialLossIds[$p['id']];
                    return true;
                }
                return false;
            });

            /**
             * Filter udanger field;
             */
            $d['data']['udanger'] = filter($d['data']['udanger'], function (&$p) use ($underDangerIds) {
                $is = isset($underDangerIds[$p['id']]);
                if ($is) {
                    $p['model'] = $underDangerIds[$p['id']];
                    return true;
                }
                return false;
            });

            return true;
        });


        /**
         * Finally , we iterate over whole filtered data again and create a record for new control/udanger or
         * omit them if that value already exists under current danger.
         * For now we divide user controls by its type and save it in $userControlsByDidForSum
         * and also we calculate the sum of all controls of each type as it's needed for RiskCalculator
         */

        /*
         * Later, we'll need all danger control k's sum, we can calculate it now.
         * For calculation, we first join danger and control tables through danger_controls and then select sum of k's.
         */
        $used = [];
        $dangerIds = [];
        foreach ($data as $ind => $d) {
            $did = $d['did'];
            if (!isset($used[$did])) {
                $used[$did] = true;
                $dangerIds[] = $did;
            }
        }

        $dangerControlsSum = DB::table('controls')
            ->join('control_dangers', 'controls.id', '=', 'control_dangers.control_id')
            ->whereIn('control_dangers.danger_id', $dangerIds)
            ->selectRaw('SUM( CAST(controls.k as DECIMAL(9,2)) ) as controls_sum, control_dangers.danger_id')
            ->groupBy('control_dangers.danger_id')
            ->get()
            ->toArray();

        $dangerControlsMap = [];
        foreach ($dangerControlsSum as $dc) {
            $dangerControlsMap[$dc->danger_id] = (double)$dc->controls_sum;
        }

        foreach ($data as &$d) {
            $d['dangerControlsSum'] = $dangerControlsMap[$d['did']];
        }

        return $data;
    }

    /**
     * Check page-completion
     * 1. Omit whole element if some required fields are missing
     * 2. Take maximum added elements that are acceptable if number of added ones exceed the norm
     *
     * @param array $data
     * @return array
     */
    public function checkPageCompletion(array $data): array
    {

        /**
         * Validator function
         *
         * @param array $element
         * @return bool
         */
        $filter = function (array $element) {
            $ok = true;

            /**
             * Whole data is set as 'data' key to $element var
             */
            $page = $element['data'];
            /**
             * At least one [type-1, type-2] should be checked or added
             */
            if (count($page['control'][0]) === 0 && count($page['control'][1]) === 0) {
                $ok = false;
            }

            /**
             * At least one [udanger, ploss] should be checked
             */
            if (count($page['udanger']) === 0 || count($page['ploss']) === 0) {
                $ok = false;
            }

            /**
             * At least one [rperson, etime] should be added
             */
            if (count($page['rpersons']) === 0 && count($page['etimes']) === 0) {
                $ok = false;
            }

            if (!$ok) {
                /**
                 * If some page does not pass validations, remove all user inputs in this page
                 */
                unset($this->addedValues[$element['did']]);
                return false;
            }

            return true;
        };

        /**
         * Validate each element separately
         */
        return array_filter($data, $filter);
    }

    /**
     * @param $a
     * @param $name
     * @param $data
     * @return bool
     */
    public function isInt($a, $name, &$data): bool
    {
        if (!preg_match('/^-?\d+$/', $a)) {
            return false;
        }

        if ($data) $data[$name] = $a;
        return true;
    }

    /**
     * @param $str
     * @return bool
     */
    public function isString($str): bool
    {
        return is_string($str) && mb_strlen($str) > 0;
    }

    /**
     * @param $a
     * @param $name
     * @param $pid
     * @param $did
     * @param $data
     * @return bool
     */
    public function filterImageName($a, $name, $pid, $did, &$data): bool
    {
        if ($a !== "image_{$pid}_{$did}") {
            return false;
        }

        $data[$name] = $a;
        return true;
    }

    /**
     * @param $d
     * @return bool
     */
    public function isDate($d): bool
    {
        if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $d)) {
            return false;
        }
        return true;
    }
}



