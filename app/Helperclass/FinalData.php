<?php

namespace App\Helperclass;

class FinalData
{
    protected $exportId = null;
    private int $mode = 0;
    private const DEFAULT_MODE = 0;

    /**
     * FinalData constructor.
     * @param $exportId
     * @param int $mode
     */
    public function __construct($exportId, $mode = self::DEFAULT_MODE) {
        $this->exportId = $exportId;
        $this->mode = $mode;
    }

    /**
     * @param $obj
     * @return array
     * @throws \Exception
     */
    public function init($obj)
    {
        if (count($obj) < 1) {
            throw new \Exception('No data provided', 400);
        }
        /**
         * $countAll is number of table columns;
         * $object is a helper to generate form in user/mydocs
         */
        [$object, $countAll] = $this->setData($obj);

        /**
         * $links is a helper variable for object to generate form. f.e when drawing form when to show new danger column, new process column etc.
         */
        $links = $this->qualify($countAll, $object);

        if ($this->mode === self::DEFAULT_MODE) {
            $json = new Json($this->exportId);
            $this->exportId = $json->save([$object, $links, $countAll]);
        } else {
            return [$object, $links, $countAll];
        }

    }

    /**
     * @return null
     */
    public function getExportId()
    {
        return $this->exportId;
    }

    /**
     * @param $all
     * @param $object
     * @return array
     */
    public function qualify($all, $object): array
    {
        $link = [];
        $currentProcessMax = $object[0]['max'];
        $currentProcessInd = 0;
        $currentDangerMax = $object[0][0]['max'];
        $currentDangerInd = 0;
        $currentElement = 0;

        $link[] = [
            'process' => 0,
            'danger' => 0,
            'element' => 0,
            'hasNewProcess' => true,
            'hasNewDanger' => true];

        for ($i = 2; $i <= $all; $i++) {
            $newProcess = null;
            $newDanger = null;

            if ($i > $currentProcessMax) {
                $newProcess = true;
                $newDanger = true;
                $currentElement = 0;
                $currentProcessInd++;
                $currentDangerInd = 0;
                $currentProcessMax += $object[$currentProcessInd]['max'];
                $currentDangerMax += $object[$currentProcessInd][0]['max'];
            } elseif ($i > $currentDangerMax) {
                $newProcess = false;
                $newDanger = true;
                $currentElement = 0;
                $currentDangerInd++;
                $currentDangerMax += $object[$currentProcessInd][$currentDangerInd]['max'];
            } else {
                $newProcess = false;
                $newDanger = false;
                $currentElement++;
            }

            $link[] = [
                'process' => $currentProcessInd,
                'danger' => $currentDangerInd,
                'element' => $currentElement,
                'hasNewProcess' => $newProcess,
                'hasNewDanger' => $newDanger
            ];

        }

        return $link;

    }

    /**
     * @param $obj
     * @return array|false
     */
    public function setData($obj)
    {
        /**
         * Variable where all the data is stored
         */
        $object = [];

        /**
         * This is just a helper variable used to easily append danger to process
         */
        $links = [];

        /**
         * Iterate over all array elements and process each of them separately
         */
        foreach ($obj as $ind => $o) {
            $dangerId = $o['did'];
            $processId = $o['pid'];

            $pkey = "id{$processId}";
            if (!isset($links[$pkey])) {
                $object[] = [];
                $links[$pkey] = count($object) - 1;
            }

            if (!isset($o['data'])) {
                return false;
            }

            $calculator = new RiskCalculator($o['dangerModel']['k'], [
                'ploss' => $o['data']['ploss'],
                'control' => $o['data']['control'],
                'dangerControlsSum' => $o['dangerControlsSum']
            ]);

            $o['data']['result'] = $calculator->getResult();

            $obj[$ind] = [
                'pid' => $processId,
                'did' => $dangerId,
                'data' => $o['data'],
                'processName' => $o['processModel']['name'],
                'dangerName' => $o['dangerModel']['name']
            ];
            $object[$links[$pkey]][] = $obj[$ind];
        }

        $object = $this->countData($object);

        return $object;
    }


    /**
     * @param $object
     * @return array
     */
    public function countData($object): array
    {
        $countAll = 0;
        foreach ($object as $n => $obj) {
            $max = 0;

            foreach ($obj as $m => $o) {
                $mx = 0;
                $o = $o['data'];
                foreach ($o['control'] as $b) $mx = max($mx, count($b));

                foreach ($o as $c => $val) {
                    if (gettype($val) == 'array' && !in_array($c, ['control', 'newControls', 'newUdangers', 'result']))
                        $mx = max($mx, count($val));
                }
                $object[$n][$m]['max'] = $mx;
                $max += $mx;
            }
            $object[$n]['max'] = $max;
            $countAll += $max;
        }

        return [$object, $countAll];
    }

}



