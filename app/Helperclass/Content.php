<?php

namespace App\Helperclass;

use App\HelperClass\Json;
use App\HelperClass\Obj;
class Content {

    protected $data = [];

    public function __construct($filename, $exportAs = ''){
        $this->init($filename, $exportAs);
    }

    public function init($filename, $exportAs){
        $json = new Json();
        $data = $json->load($filename);

        $countAll = $data[2];
        $object = new Obj($data[0], $data[1], $data[2], $exportAs);

        $this->data =  [$countAll, $object];
    }

    public function getData(){
        return $this->data;
    }
}



