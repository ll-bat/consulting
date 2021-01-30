<?php

namespace App;

use App\ControlDanger;
use Illuminate\Database\Eloquent\Model;

class Danger extends Model
{
    protected $fillable = ['name', 'k', 'field_id'];

    public function getAllProcess(){
        return $this->belongsToMany(Process::class);
    }

    public function processes(){
        return DangerProcess::where('danger_id', $this->id)->get();
    }

    public function getProcess(){
        return $this->processes()->pluck('process_id');
    }

    public function getControls(){
        return $this->hasMany(Control::class);
    }

    public function getAllControl(){
        return ControlDanger::where('danger_id', $this->id)->get();
    }

    public function getControl(){
        return $this->getAllControl()->pluck('control_id');
    }

    public function getControlIds(){
        $ids = [];
        foreach ($this->getControl() as $id){
            $ids[] = $id;
        }
        return $ids;
    }
}
