<?php

namespace App\Helperclass;


class Data {

    protected $data = null;

    public function __construct($data){
        $this->setData($data);
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getData(){
        return $this->data;
    }
}



