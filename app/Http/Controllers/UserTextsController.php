<?php

namespace App\Http\Controllers;

use App\UserText;
use App\Danger;
use App\Udanger;
use App\Control;
use App\ControlDanger;
use Illuminate\Http\Request;

class UserTextsController extends Controller
{
      public function index(){
           $dangers = [];
           $controls = UserText::where('type', 'control')->get();
           $udangers = UserText::where('type' ,'udanger')->get();
           $empty = $controls->count() == 0 && $udangers->count() == 0;

           foreach ($controls as $c){
               $d =  Danger::find($c->danger_id)->name;
               $dangers[$d][] = $c;
           }

           return view('admin.docs.usertexts', compact('dangers', 'udangers', 'empty'));
      }

      public function editControl($id){
          $model   = UserText::findOrFail($id);
          $dangers = Danger::all();
          
          return view('admin.docs.edit-usertext-control', compact('model', 'dangers'));
      }

      public function editUdanger($id){
          $udanger   = UserText::findOrFail($id);

          return view('admin.docs.edit-usertext-udanger', compact('udanger'));
      }

      public function deleteControl($id){
        $model   = UserText::find($id);
        $model->delete();
        
        return redirect()->to('user/docs/added-by-users')->with('message', 'კონტროლის ზომა წარმატებით წაიშალა');
    }

      public function updateControl($id){
        $data = \request()->validate([
            'name' => ['required', 'string'],
            'k'   => 'numeric|nullable',
            'rploss' => 'boolean',
            'danger' => 'array',
            'danger.*' => 'integer|exists:dangers,id'
        ]);

        $data['danger'] = $data['danger'] ?? [];

        if (isset($data['rploss'])) $data['rploss'] = true;
        else $data['rploss'] = false;
        
        $data['k'] = $data['k'] ?? 1;

        $control = Control::create($data);
        $control->dangers()->attach($data['danger']);

        $model   = UserText::find($id); 
        $model->delete();
        
        return redirect()->to('user/docs/added-by-users')->with('message', 'კონტროლის ზომა წარმატებით დაემატა');
    }

    public function updateUdanger($id){
        $data = request()->validate([
             'name' => 'string|required'
        ]);

        Udanger::create(['name' => $data['name']]);
        $id = intval($id);
        $model = UserText::findOrFail($id);
        $model->delete();
        
        return redirect()->to('user/docs/added-by-users')->with('message', 'ოპერაცია წარმატებით შესრულდა');
    }

    public function store($model){
             if (gettype($model) == 'string'){
               $model = UserText::findOrFail($model);
             }

             $control = Control::create(['name' => $model->name, 'k' => '1', 'rploss' => 0]);
             $control->dangers()->attach([$model->danger_id]);
             $model->delete();
             
             $cnt = UserText::where('danger_id', $model->danger_id)->count();

            return response($cnt, 200);
      }

      public function storeUdanger($model){
            if (gettype($model) == 'string'){
                $model = UserText::findOrFail($model);
            }

            $udanger  = Udanger::create(['name' => $model->name]);
            $model->delete();

            $cnt = UserText::where('type', 'udanger')->count();

            return response($cnt, 200);
      }

      public function deleteUdanger($model){
          if (in_array(gettype($model),['string', 'integer'])){
                $model = UserText::findOrFail(intval($model));
          }

          $model->delete();
          
          $cnt = UserText::where('type', 'udanger')->count();

          return redirect()->to('user/docs/added-by-users')->with('message', 'ოპერაცია წარმატებით შესრულდა');
      }
}
