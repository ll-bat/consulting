<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $fillable = ['name', 'k', 'rploss'];

    public function dangers(){
        return $this->belongsToMany(Danger::class,'control_dangers');
    }

    public function allControl(){
        return ControlDanger::where('control_id', $this->id)->get();
    }

    public function getAllControl(){
        return $this->allControl()->pluck('danger_id');
    }

    public function hasRPLoss(){
        return $this->rploss == true;
    }

    public function getNrploss(){
        if ($this->hasRPLoss()) return 0;
        return 1;
    }
}
