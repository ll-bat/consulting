<?php

namespace App\Helperclass;

use App\Helperclass\Json;
use App\Helperclass\Obj;

class Content {

    protected $data = [];

    public function __construct($export, $exportAs = ''){
        $this->init($export, $exportAs);
    }

    public function init($export, $exportAs){
        $json = new Json();
        $data = $json->load($export);

        $countAll = $data[2];
        $object = new Obj($data[0], $data[1], $data[2], $exportAs);

        $this->data =  [$countAll, $object];
    }

    public function getData(){
        return $this->data;
    }
}



