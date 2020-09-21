<?php

namespace App\Helperclass;


class ExcelReader {

    protected $data = null;

    public function __construct($data){
        $this->qualify($data[0]);
    }

    public function qualify($data){
        $ind = count($data) - 1;

           foreach ($data[$ind] as $k => $d){
               if ($d != null){
                   $ind = $k; break;
               }
           }

           $h = null;
           foreach ($data as $k => $d){
                if ($d[$ind] != null){
                    $h = $k; break;
                }
           }

           $obj = [];
           for ($i = $h+1; $i<count($data); $i++){
               for ($j = $ind; $j < count($data[$i]); $j++)
                  $obj[$i][] = $data[$i][$j];
           }

           $this->data = $obj;
    }

    public function getData(){
        return $this->data;
    }
}



