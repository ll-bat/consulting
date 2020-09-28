<?php

namespace App\Helperclass;


use App\Export;
use Illuminate\Support\Facades\File;


class Json {

    
    public function __construct(){

    }

    public static function sload($export){
        $data = json_decode($export->data, true);

        return $data;
    }

    public function load($export){
        // $json = File::get($path);
        $data = json_decode($export->data, true);

        return $data;
    }

    public function save($data){
        $data = json_encode($data);

        $name = md5(uniqid());
        $path = "$name.json";
        
        $export = Export::create(['user_id' => current_user()->id, 'filename' => $path, 'data' => $data]);
        // File::put("{$path}", $json);
        return $export->id;
    }
}



