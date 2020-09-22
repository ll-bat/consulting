<?php

namespace App\Helperclass;

use App\Control;
use App\Danger;
use App\Process;
use App\Ploss;
use App\Udanger;
use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\RiskCalculator;

class FinalData {

    protected $exportId = null;
 
    public function init($obj){
        [$object, $countAll]  = $this->setData($obj);
        
        $links    = $this->qualify($countAll, $object);

        $json = new Json();
        $this->exportId =  $json->save([$object,$links, $countAll]);
    }

    public function getExportId(){
        return $this->exportId;
    }

    public function qualify($all, $object){
        $link       = [];

        $newProcess = true;
        $newDanger    = true;

        $currentProcessMax = $object[0]['max'];
        $currentProcessInd = 0;
        $currentDangerMax  = $object[0][0]['max'];
        $currentDangerInd  = 0;
        $currentElement    = 0;

        $link[] = ['process' => 0, 'danger' => 0, 'element' => 0, 'hasNewProcess' => true, 'hasNewDanger' => true];

        for ($i = 2; $i <= $all; $i++){
            $newProcess = null;
            $newDanger  = null;

            if ($i > $currentProcessMax){
                $newProcess = true;
                $newDanger  = true;
                $currentElement = 0;
                $currentProcessInd++;
                $currentDangerInd = 0;
                $currentProcessMax += $object[$currentProcessInd]['max'];
                $currentDangerMax  += $object[$currentProcessInd][0]['max'];
            }
            elseif ($i > $currentDangerMax){
                $newProcess = false;
                $newDanger  = true;
                $currentElement = 0;
                $currentDangerInd++;
                $currentDangerMax += $object[$currentProcessInd][$currentDangerInd]['max'];
            }

            else {
                $newProcess = false;
                $newDanger  = false;
                $currentElement++;
            }

            $link[] = ['process' => $currentProcessInd,
                       'danger'  => $currentDangerInd,
                       'element' => $currentElement,
                       'hasNewProcess' => $newProcess,
                       'hasNewDanger' => $newDanger
             ];

        }

        return $link;

    }
     

    public function setData($obj){
        $object = [];
        $links  = [];

        $controlAnswers = ['არსებული', 'დამატებითი', 
                          'არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება'];

        foreach ($obj as $ind => $o){
            $dangerId = $o['did'];
            $processId = $o['pid'];

            $process = Process::findOrFail($processId);
            if (!in_array($dangerId, $process->getDangerIds())){
                unset($obj[$ind]);
                continue;
            }

            $pkey = "id{$processId}";
            if (!isset($links[$pkey]))
            {
                $object[] = [];
                $links[$pkey] = count($object) - 1;
            }

            $danger = Danger::findOrFail($dangerId);
            $conIds = $danger->getControlIds();

            if (!isset($o['data'])) return false;
            $o = $o['data'];

            foreach ($o['control'] as $ind => $r){
                 foreach ($r as $i => $c){
                     if (in_array($c['id'], $conIds)){
                         $con = Control::find($c['id']);
                         $o['control'][$ind][$i]['model'] = ['name' => $con->name, 'k' => $con->k, 'rploss' => $con->rploss];
                     }
                     else {
                         unset($o['control'][$ind][$i]);
                     }
                }
            }

            foreach ($o['ploss'] as $ind => $p){
                $ploss = Ploss::findOrFail($p['id']);
                $o['ploss'][$ind]['model'] = ['name' => $ploss->name, 'k' => $ploss->k];
            }


            foreach ($o['udanger'] as $ind => $d){
                $udanger = Udanger::findOrFail($d['id']);
                $o['udanger'][$ind]['model'] = ['name' => $udanger->name];
            }


            $calculator = new RiskCalculator($danger, $conIds, $o);
            $o['result'] = $calculator->getResult();

            $obj[$ind] = ['pid' => $processId, 'did' => $dangerId,
                          'data' => $o,
                          'processName' => $process->name,
                          'dangerName'  => $danger->name
                        ];
            $object[$links[$pkey]][] = $obj[$ind];
         }

         $object = $this->countData($object);

         return $object;
      }


      public function countData($object){
        $countAll = 0;
        foreach ($object as $n => $obj){
            $max = 0;

            foreach ($obj as $m => $o){
                $mx = 0;
                $o = $o['data'];
                foreach ($o['control'] as $b) $mx = max($mx, count($b));

                foreach ($o as $c => $val){
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



