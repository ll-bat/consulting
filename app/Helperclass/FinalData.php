<?php

namespace App\Helperclass;

use Exception;

class FinalData
{
    private $exportId = null;
    private int $mode = 0;
    public const DEFAULT_MODE = 0;
    public const RETURN_DATA = 1;
    private bool $wantsToSave = true;

    /**
     * FinalData constructor.
     * @param $exportId
     * @param int $mode
     */
    public function __construct($exportId, $mode = self::DEFAULT_MODE)
    {
        $this->exportId = $exportId;
        $this->mode = $mode;
    }

    /**
     * @return null
     */
    public function getExportId()
    {
        return $this->exportId;
    }

    /**
     * @param $obj
     * @param int $fieldId
     * @param null $document_headers
     * @return array|bool
     * @throws Exception
     */
    public function init($obj, int $fieldId = -1, $document_headers = null)
    {
        if (count($obj) < 1) {
            throw new Exception('No data provided', 400);
        }
        /**
         * $countAll is number of table columns;
         * $object is a helper to generate form in user/mydocs
         */
        [$object, $countAll] = $this->formatDataAndDoRisksCalculations($obj);

        /**
         * $links is a helper variable for object to generate form. f.e when drawing form when to show new danger column, new process column etc.
         */
        $links = $this->getTableElements($countAll, $object);

        if ($this->mode === self::DEFAULT_MODE) {
            /**
             * Create new instance of Json class to get/set export data
             */
            $json = new Json($this->exportId);

            /**
             * Set fieldId to search export in.
             */
            if ($fieldId < 1) {
                throw new Exception('Wrong field id');
            }

            $json->setFieldId($fieldId);

            /**
             * Update data and get updated/created export id and its data before updating
             */
            $this->exportId = $json->save([$object, $links, $countAll], $document_headers);

            return true;

        } else {
            /**
             * In this case, we don't want to update or create export.
             * Instead return that data.
             */
            return [$object, $links, $countAll];
        }

    }

    /**
     * @param $all
     * @param $object
     * @return array
     */
    public function getTableElements($all, $object): array
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
    public function formatDataAndDoRisksCalculations($obj)
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
         * Iterate over each array element and process them separately
         * First, we group them by processId.
         * Next, we do risk calculations for each danger
         * When this is done, we count elements in each group (This is a helper variable to show data in table , later)
         */
        foreach ($obj as $ind => $o) {
            $dangerId = $o['did'];
            $processId = $o['pid'];

            if (!isset($o['data'])) {
                continue;
            }

            $pkey = $processId;
            if (!isset($links[$pkey])) {
                $object[] = [];
                $links[$pkey] = count($object) - 1;
            }

            $calculator = new RiskCalculator($o['dangerModel']['k'], [
                'ploss' => $o['data']['ploss'],
                'control' => $o['data']['control'],
                'dangerControlsSum' => $o['dangerControlsSum']
            ]);

            $o['data']['result'] = $calculator->getResult();

            $object[$links[$pkey]][] = [
                'pid' => $processId,
                'did' => $dangerId,
                'data' => $o['data'],
                'processName' => $o['processModel']['name'],
                'processModel' => $o['processModel'],
                'dangerName' => $o['dangerModel']['name'],
                'dangerModel' => $o['dangerModel'],
                'dangerControlsSum' => $o['dangerControlsSum']
            ];

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

                foreach ($o['control'] as $b) {
                    $mx = max($mx, count($b));
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



