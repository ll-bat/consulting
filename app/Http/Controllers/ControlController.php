<?php

namespace App\Http\Controllers;

use App\Control;
use App\Danger;
use App\ControlDanger;
use Illuminate\Http\Request;

class ControlController extends Controller
{
      
    public function newControl(){
        $dangers  = Danger::all();
        $controls = Control::orderBy('created_at','asc')->get();
        return view("admin.docs.control", compact('dangers', 'controls'));
    }

    public function createControl(){
        $data = \request()->validate([
             'name' => 'required|string',
             'k' => 'nullable|numeric',
             'rploss' => 'boolean',
             'danger' => 'array',
             'danger.*' => 'integer|exists:dangers,id'
        ]);

        $data['k'] = $data['k'] ?? 1;

        $control = Control::create($data);
        if (isset($data['danger']))
           $control->dangers()->attach($data['danger']);
        
        return back()->with('message', 'კონტროლის ზომა შეიქმნა წარმატებით')->with('created', '1');
    }

    public function edit(Control $control){
        $list = [];
        foreach ($control->getAllControl() as $c)
           $list[] = $c;

        return view('admin.docs.edit-control', [
            'control' => $control,
            'dangers'  => Danger::all(),
            'list'   => $list
        ]);
    }

    public function update(Control $control){
        $data = \request()->validate([
            'name' => ['required', 'string'],
            'k'   => 'numeric|nullable',
            'rploss' => 'boolean',
            'danger' => 'array',
            'danger.*' => 'integer|exists:dangers,id'
        ]);

        $data['danger'] = $data['danger'] ?? [];

        if (isset($data['rploss'])){
            $data['rploss'] = true;
        }
        else $data['rploss'] = false;
        
        $data['k'] = $data['k'] ?? 1;
        
        $list = [];

        foreach ($control->allControl() as $c){
              $list[] = $c->danger_id;
        }

        foreach ($list as $l) {
            if (!in_array($l, $data['danger'])){
                $control->dangers()->detach(['danger_id' => $l]);
            }
        }

        foreach ($data['danger'] as $p){
            if (!in_array($p, $list)){
                $control->dangers()->attach($p);
            }
        }

        $control->update($data);

        return back()->with('message', 'კონტროლის ზომა წარმატებით განახლდა');
    }

    public function delete(Control $control){
        ControlDanger::where('control_id', $control->id)->delete();
        $control->delete();
        return response('done', 200);
    }

    public function rdelete(Control $control){
        $this->delete($control);
        return redirect()->to('user/docs/new-control')->with('message', 'კონტროლის ზომა წარმატებით წაიშალა');
    }
}
