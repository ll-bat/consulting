<?php

namespace App\Http\Controllers;

use App\Process;
use App\Danger;
use App\Control;
use App\DangerProcess;
use App\ControlDanger;
use Illuminate\Http\Request;

class DangerController extends Controller
{
    public function show(){
        return view('admin.docs.danger', [
            'procs' => Process::all(),
            'dangers' => Danger::orderBy('created_at','asc')->get()
        ]);
    }

    public function create(){
        $data = \request()->validate([
            'name' => 'required|string',
            'k'   => 'numeric|nullable',
            'process' => 'array',
            'process.*' => 'integer|exists:processes,id',
        ]);
        
        $data['k'] = $data['k'] ?? 1;
        
        $danger = Danger::create($data);
        if (isset($data['process']))
          $danger->getAllProcess()->attach($data['process']);

        return back()->with('message', 'საფრთხე წარმატებით შეიქმნა')->with('created', '1');
    }

    public function edit(Danger $danger){
        $list = [];
        foreach ($danger->getProcess() as $p)
           $list[] = $p;

        $l = [];


        foreach ($danger->getControl() as $c){
            $l[] = $c;
        }

        $ycontrol = Control::whereIn('id', $l)->get();
        $ncontrol = Control::whereNotIn('id', $l)->get();

        return view('admin.docs.edit-danger', [
            'danger' => $danger,
            'procs'  => Process::all(),
            'list'   => $list,
            'ycontrol' => $ycontrol,
            'ncontrol' => $ncontrol
        ]);
    }

    public function update(Danger $danger){
        $data = \request()->validate([
            'name' => 'required|string',
            'k'   => 'numeric|nullable',
            'process' => 'array',
            'process.*' => 'integer|exists:processes,id'
        ]);

        $data['process'] = $data['process'] ?? [];

        $data['k'] = $data['k'] ?? 1;
        
        $list = [];
        foreach ($danger->processes() as $proc){
              $list[] = $proc->process_id;
        }

        foreach ($list as $l) {
            if (!in_array($l, $data['process'])){
                $danger->getAllProcess()->detach(['process_id' => $l]);
            }
        }

        foreach ($data['process'] as $p){
            if (!in_array($p, $list)){
                $danger->getAllProcess()->attach($p);
            }
        }

        $danger->update($data);

        return back()->with('message', 'საფრთხე წარმატებით განახლდა');
    }

    public function delete(Danger $danger){


        DangerProcess::where('danger_id', $danger->id)->delete();
        ControlDanger::where('danger_id', $danger->id)->delete();
        
        if ($danger->getAllControl()->count() > 0){
            // return back()->with('error', 'გთხოვთ, ამოშალოთ ყველა შემავალი კონტროლის ზომა');
        }

        $danger->delete();

        return redirect()->to('user/docs/new-danger')->with('message', 'საფრთხე წარმატებით წაიშალა');
    }


    public function copy(Danger $danger){
        $newdanger = Danger::create(['name' => $danger->name, 'k' => $danger->k]);
        
        foreach ($danger->getAllControl() as $c){
            ControlDanger::create(['control_id' => $c->control_id, 'danger_id' => $newdanger->id]);
        }

        return back()->with('message','საფრთხე წარმატებით დაკოპირდა')->with('created', 1);
    }

    public function detach(Danger $danger, Control $control){
        ControlDanger::where('danger_id', $danger->id)->where('control_id',$control->id)->delete();

        return back()->with('message', 'კონტროლის ზომა წარმატებით ამოიშალა');
   }

   public function attach(Danger $danger, Control $control){
        ControlDanger::create(['danger_id' => $danger->id, 'control_id' => $control->id]);

        return back()->with('message', 'კონტროლის ზომა წარმატებით დაემატა');
   }
}
