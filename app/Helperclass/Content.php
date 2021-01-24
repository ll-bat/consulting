<?php

namespace App\Helperclass;

use App\Helperclass\Json;
use App\Helperclass\Obj;

class Content {

    protected $data = [];

    /**
     * Content constructor.
     * @param $export
     * @param string $exportAs
     */
    public function __construct($export, $exportAs = ''){
        $this->init($export, $exportAs);
    }

    /**
     * @param $export
     * @param $exportAs
     */
    public function init($export, $exportAs){
        $json = new Json();
        $data = $json->load($export);

        $countAll = $data[2];
        $object = new Obj($data[0], $data[1], $data[2], $exportAs);

        $this->data =  [$countAll, $object];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}



