<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $fillable = ['name', 'field_id'];

    public function getDangers(){
        return DangerProcess::where('process_id', $this->id)->get();
    }

    public function getDangerIds(){
        $list = [];
        $data =  $this->getDangers()->pluck('danger_id');
        foreach ($data as $d){
            $list[] = $d;
        }
        return $list;
    }


}
