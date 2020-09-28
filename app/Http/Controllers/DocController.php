<?php


namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\Process;
use App\Ploss;
use App\Udanger;
use App\UserText;
use App\Helperclass\Data;
use App\Helperclass\Filter;
use App\Helperclass\FinalData;
use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\RiskCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DocController extends Controller
{
      public function index()
      {
           $cnt = UserText::count();
           $procs = Process::all();

           return view('admin.docs.index', compact('procs', 'cnt'));
      }

      public function show(){
           return view('admin.docs.check');
      }


      public function getAll(){
          $process = Process::select('id', 'name')->get();
          $danger  = Danger::select('id', 'name')->get();
          $control = Control::select('id','name')->get();

          foreach ($process as $p)
             $p->data = $p->getDangerIds();

          foreach ($danger as $d)
              $d->data = $d->getControl();
          
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
            else $d = $d['data'];
            if ($d['hasImage'])
               $rule[$d['imageName']] = 'required|image|mimes:jpeg,png,jpg|max:2048';
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
              $did = $d['did'];
              if (!isset($d['data'])) continue;
              else $d = $d['data'];

              if ($d['hasImage']){
                //   $name = request($d['imageName'])->store('testing');
                  $name = cloudinary()->upload(request($d['imageName'])->getRealPath())->getSecurePath(); 
                  $data[$ind]['data']['imageName'] = $name;
              }

              foreach ($d['newControls'] as $nc){
                    $model = UserText::where(['danger_id' => $did, 'name' => $nc['value'], 'type' => 'control'])->first();

                    if (!$model){
                          UserText::create(['user_id' => current_user()->id, 
                                      'danger_id' => $did, 'name' => $nc['value'], 
                                      'type' => 'control']);
                    }
              }

              foreach ($d['newUdangers'] as $nc){
                    $model = UserText::where(['danger_id' => $did, 'name' => $nc['value'], 'type' => 'udanger'])->first();
                   
                    if (!$model){
                          UserText::create(['user_id' => current_user()->id, 
                                      'danger_id' => $did, 'name' => $nc['value'],
                                      'type' => 'udanger']);
                    }
              }

          }

          $obj->setData($data);
          session()->put('data', $obj);

          return response('completed', 200);
      }

      public function showData(){
          $obj = session()->get('data')->getData();

          $reader = new FinalData();
          $reader->init($obj);

          session()->forget('data');
          return redirect()->route('user.export', ['export' => $reader->getExportId()]);
      }

}
