<?php

namespace App\Helperclass;

use App\Control;
use App\ControlDanger;
use App\Danger;
use App\DangerProcess;
use App\Ploss;
use App\Process;
use App\Udanger;
use Illuminate\Support\Facades\DB;

class Filter
{

    private $data;
    private $oldImages;
    private $imageNameValidator = [];

    public function __construct($obj)
    {
        $this->oldImages = session()->get('oldImages') ?? [];
        $data = $this->filterUserInputs($obj);
        $this->filterData($data);
    }

    public function getData()
    {
        return $this->data;
    }

    public function filterUserInputs($obj)
    {
        $newobj = [];

        foreach ($obj as $o) {
            try {
                $d = $this->filter($o);
                if (!$d) continue;
            } catch (\Exception $e) {
                continue;
            }
            $newobj[] = $d;
        }

        session()->put('rule', $this->imageNameValidator);

        return $newobj;
    }

    public function filter($o)
    {
        /**
         * Check variables and their values. If at least one variable has invalid type or value, omit whole element...
         */

        $obj = [];
        $data = [];
        $false = false;

        /**
         * DangerId should of type integer
         */


        if ($this->isInt($o['did'], '', $false)) {
            $obj['did'] = $o['did'];
        }
        else {
            return false;
        }


        /**
         * ProcessId should of type integer
         */
        if ($this->isInt($o['pid'], '', $false)) {
            $obj['pid'] = $o['pid'];
        }
        else {
            return false;
        }

        list($pid, $did) = [$obj['pid'], $obj['did']];

        /**
         * Data should be of type array
         */
        if (gettype($o['data']) != 'array') {
            return false;
        }
        $o = $o['data'];

        /*
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
                    // @TODO: Implement image deletion .
                }
                $this->imageNameValidator[$data['imageName']] = 'required|image|mimes:jpeg,png,jpg|max:2048';
            } else {
                return false;
            }
        } else {
            if ($hasOldImage) {
                if (!isset($o['oldImage']) || !$o['oldImage']) {
                    // @TODO: Implement old image deletion .
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

        $data['control'] = [[], [], []];
        foreach ($o['control'] as $c) {
            if (!isset($c['id']) || !isset($c['value'])) {
                continue;
            }
            if (!$this->isInt($c['id'], '', $false) || !$this->isInt($c['value'], '', $false)) {
                continue;
            }
            if (!in_array($c['value'], [0, 1, 2])) continue;

            $data['control'][$c['value']][] = ['id' => $c['id'], 'value' => $c['value']];
        }

        /*
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
        $types = [
            'newControls' => 'isString',
            'newUdangers' => 'isString',
            'rpersons' => 'isString',
            'etimes' => 'isDate'
        ];

        foreach ($types as $type => $filter) {
            $data[$type] = [];
            if (gettype($o[$type]) == 'array') {
                foreach ($o[$type] as $n) {
                    if (isset($n['value'])) {
                        if (call_user_func([static::class, $filter], $n['value'])) {
                            $data[$type][] = ['value' => $n['value']];
                        }
                    }
                }
            }
        }

        $obj['data'] = $data;

        return $obj;
    }

    /**
     *  Checks process, danger, control - ids. Omit element if proper records does not exist in database
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

        $dangerProcesses = DangerProcess::whereIn('danger_id', $dangers)
            ->whereIn('process_id', $processes)
            ->select('danger_id', 'process_id')
            ->get()
            ->toArray();

        $dangerProcessIds = [];
        foreach ($dangerProcesses as $ind => $pair) {
            if (!isset($dangerProcessIds[$pair['process_id']])) {
                $dangerProcessIds[$pair['process_id']] = [];
            }
            $dangerProcessIds[$pair['process_id']][$pair['danger_id']] = true;
        }

        $controls = [];$potentialLoss = []; $underDanger = [];
        $used = []; $first = []; $second = [];
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

        $potentialLoss = Ploss::whereIn('id', $potentialLoss)
            ->select('id', 'name', 'k')
            ->get()
            ->toArray();

        $potentialLossIds = [];
        foreach ($potentialLoss as $p) {
            $potentialLossIds[$p['id']] = ['name' => $p['name'], 'k' => $p['k']];
        }

        $underDanger = Udanger::whereIn('id', $underDanger)
            ->select('id', 'name')
            ->get()
            ->toArray();

        $underDangerIds = [];
        foreach ($underDanger as $p) {
            $underDangerIds[$p['id']] = ['name' => $p['name']];
        }

        $controlDangerIds = [];
        foreach ($controlDangers as $c) {
            if (!isset($controlDangerIds[$c['danger_id']])) {
                $controlDangerIds[$c['danger_id']] = [];
            }
            $controlDangerIds[$c['danger_id']][$c['control_id']] = true;
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
        $data = filter($data, function (&$d) use($processIds, $dangerProcessIds, $controlDangerIds, $potentialLossIds, $underDangerIds, $dangersMap, $controlsMap) {
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
            $d['data']['control'] = array_map(function ($type) use($controlDangerIds, $did, $controlsMap) {
                return filter($type, function (&$c) use($controlDangerIds, $did, $controlsMap) {
                   if (!isset($controlDangerIds[$did]) || !isset($controlDangerIds[$did][$c['id']])) {
                       return false;
                   }
                   $c['model'] = $controlsMap[$c['id']];
                   return true;
                });
            }, $d['data']['control']);

            /**
             * Ploss and udanger have same structure, we can combine these two loops into one, but to make it easier to understand, we write them separately.
             */
            $d['data']['ploss'] = filter($d['data']['ploss'], function (&$p) use($potentialLossIds) {
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
            $d['data']['udanger'] = filter($d['data']['udanger'], function (&$p) use($underDangerIds) {
               $is = isset($underDangerIds[$p['id']]);
               if ($is) {
                   $p['model'] = $underDangerIds[$p['id']];
                   return true;
               }
               return false;
            });

            return true;
        });

        /*
         * Later, we'll need all danger control k's sum, we can calculate it now.
         * For calculation, we first join danger and control tables through danger_controls and then select sum of k's.
         */
        $used = [];
        $dangerIds = [];
        foreach ($data as $d) {
            $did = $d['did'];
            if (!isset($used[$did])) {
                $used[$did] = true;
                $dangerIds[] = $did;
            }
        }
        $dangerControlsSum = DB::table('controls')
            ->join('control_dangers', 'controls.id', '=', 'control_dangers.control_id')
            ->whereIn('control_dangers.danger_id', $dangerIds)
            ->selectRaw('SUM(controls.k) as controls_sum, control_dangers.danger_id')
            ->groupBy('control_dangers.danger_id')
            ->get()
            ->toArray();

        $dangerControlsMap = [];
        foreach ($dangerControlsSum as $dc) {
            $dangerControlsMap[$dc->danger_id] = $dc->controls_sum;
        }

        foreach ($data as &$d) {
            $d['dangerControlsSum'] = $dangerControlsMap[$d['did']];
        }

        $this->data = $data;
        return $data;
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
        return is_string($str);
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



