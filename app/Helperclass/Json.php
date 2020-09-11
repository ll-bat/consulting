<?php

namespace App\Helperclass;


use App\Export;
use Illuminate\Support\Facades\File;


class Json {

    
    public function __construct(){

    }

    public function load($path){
        $json = File::get($path);
        $data = json_decode($json, true);
        
        return $data;
    }

    public function save($data){

        $json = json_encode($data);

        $id = uniqid();
        $path = "storage/exports/{$id}.json";
        Export::create(['user_id' => current_user()->id, 'filename' => $path]);

        File::put("{$path}", $json);
    }
}



