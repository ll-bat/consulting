<?php


namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Process;
use App\Ploss;
use App\Udanger;
use App\Helperclass\Data;
use App\Helperclass\Filter;
use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\RiskCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DocController extends Controller
{
      public function index()
      {
           $procs = Process::all();

           return view('admin.docs.index', compact('procs'));
      }

      public function show(){
           return view('admin.docs.check');
      }


      public function getAll(){
          $process = Process::select('id', 'name')->get();

          foreach ($process as $p){
              $p->data = $p->getDangerIds();
          }

          $danger  = Danger::select('id', 'name')->get();

          foreach ($danger as $d){
              $d->data = $d->getControl();
          }

          $control = Control::select('id','name')->get();
          
          return [$process,$danger,$control];
      }

      public function otherData(){
          $ploss = Ploss::select('id','name')->get();
          $udanger =  Udanger::select('id', 'name')->get();

          return [$ploss,$udanger];
      }

      public function submit(Request $request){
        $req = $request->validate([
            'data' => 'required|array'
        ]);


        $filter = new Filter($req['data']);
        $data   = $filter->getData();

        $rule = [];
        foreach ($data as $d) {
            if (!isset($d['data'])) continue;
            $d = $d['data'];
            if ($d['hasImage'])
               $rule[$d['imageName']] = 'required|image';
        }

        $obj = new Data($data);

        session()->put('rule', $rule);
        session()->put('data', $obj);

        return response('done', 200);
      }

      public function saveData(Request $request){
          $rule = session()->get('rule');
          $obj  = session()->get('data');

          $request->validate($rule);

          $data = $obj->getData();

          foreach ($data as $ind => $d){
              if (!isset($d['data'])) continue;
              $d = $d['data'];
              if ($d['hasImage']){
                  $name = request($d['imageName'])->store('testing');
                  $data[$ind]['data']['imageName'] = $name;
              }
          }

          $obj->setData($data);
          session()->put('data', $obj);

          return response('completed', 200);
      }

      public function showData(){
          $obj = session()->get('data')->getData();

          session()->forget('data');

          $data = $this->setData($obj);

          $countAll = $data[1];
          $object   = $data[0];

          $links    = $this->qualify($countAll, $object);

        //   dd($links);
        
          $jsonData = [$object,$links, $countAll];
          $object = new Obj($object, $links, $countAll);
          
          $json = new Json();
          $json->save($jsonData);

        //   dd($object->getControl(0,0));

          return view('user.docs.form',compact('countAll', 'object'));
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

        $controlAnswers = ['არსებული', 'დამატებითი', 'არ არის აუცილებელი ან შესაძლებელი არ არის გამოყენება'];

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

            // dd($object);
             
            return $object;
      }

      public function countData($object){
        $countAll = 0;
        foreach ($object as $n => $obj){
            $max = 0;

            foreach ($obj as $m => $o){
                $mx = 0;
                $o = $o['data'];
                $mx = max($mx, max(count($o['control'][0]), max(count($o['control'][1]), count($o['control'][2]))));
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
