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

    public function filterDangerField($d){
        if (count($d) != 5){
            return false;
        }

        if (!is_string($d[0])){
            return false;
        }

        if (!is_numeric($d[1])){
            return false;
        }

        return $this->filterControlField([$d[2], $d[3], $d[4]]);
    }

    public function filterControlField($c){
        if (count($c) != 3) {
            return false;
        }

        if (!is_string($c[0])){
            return false;
        }

        if (!is_numeric($c[1])){
            return false;
        }

        if (!in_array(intval($c[2]), [0,1])){
            return false;
        }

        return true;
    }

    public function getData(){
        return $this->data;
    }
}



