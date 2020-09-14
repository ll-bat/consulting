<?php

namespace App\Helperclass;

use Illuminate\Support\Facades\Storage;


class Obj {

    protected $object   = null;
    protected $links    = null;
    protected $all      = null;
    protected $exportAs = null;
    protected $images   = [];

    public function __construct($data, $links, $all, $exportAs=''){
        $this->setData($data,$links,$all,$exportAs);
    }

    public function setData($data,$links,$all,$exportAs){
        $this->object   = $data;
        $this->links    = $links;
        $this->all      = $all;
        $this->exportAs = $exportAs;
    }


    public function getData(){
        return [$this->object, $this->links, $this->all];
    }


    public function getObject($i){
        $pid = $this->getProcessId($i);
        $did = $this->getDangerId($i);

        return $this->object[$pid][$did]['data'];
    }

    public function shrink($con){
        if ($this->exportAs != 'pdf') return $con;
        if (!is_string($con)) return $con;
        if (mb_strlen($con) == 0) return $con;

        $con = trim($con);
        if (mb_strlen($con) > 30) return mb_substr($con, 0, 28).'...';
        return $con;
    }

    public function getArrayElement($name, $i){
        $obj = $this->getObject($i);
        $elm = $this->getElementId($i);

        $el = $this->getExactElement($obj,$name, $elm);
        $el = $this->shrink($el);

        return $el;
    }

    public function getExactElement(&$data, $name,  $elm){
        if (count($data[$name]) > $elm){
            return $data[$name][$elm]['model']['name'];
        }
        return '----';
    }

    public function getStringElement($name,$i){
        $obj = $this->getObject($i);

        $el = $obj[$name];
        $el = $this->shrink($el);


        if ($el != '') return $el;
        return '----';
    }

    public function getControl($type,$i){
        $obj = $this->getObject($i);
        $elm = $this->getElementId($i);

        $controls = &$obj['control'];

        if (count($controls[$type]) > $elm){
            $el =  $controls[$type][$elm]['model']['name'];
            $el = $this->shrink($el);

            return $el;
        }

        return '----';
    }

    public function  getResult($name, $i){
        $obj = $this->getObject($i);

        return $obj['result'][$name];
    }

    public function hasImage($i){
        $obj = $this->getObject($i);

        return $obj['hasImage'];
//         return false;
    }

    public function getImageName($i, $type = 'full'){
        $obj  = $this->getObject($i);
        $path = $obj['imageName'];

        if ($type == 'full')
          $path = asset("storage/{$obj['imageName']}");

        // $file = Storage::get("{$obj['imageName']}");
        // dd($file);
        // return response($file, 200)->header('Content-Type', 'image/jpeg');
        return $path;
    }

    public function getImageContent($i){
        $obj  = $this->getObject($i);
        $path = asset("storage/{$obj['imageName']}");

        $file = Storage::get("{$obj['imageName']}");

        return $file;
    }

    public function getImages(){
        $images = [];
        for ($i=0; $i<$this->all; $i++){
            if (!$this->hasNewDanger($i)) continue;
            $has = $this->hasImage($i);
            $path = '';

            if ($has){
                $path = $this->getImageName($i, 'partial');
                $path = public_path("storage/$path");
            }

            $pid  = $this->getProcessId($i);
            $did  = $this->getDangerId($i);
            $max  = $this->object[$pid][$did]['max'];
            $images[] = ['max' => $max, 'has' => $has, 'path' => $path];
        }
        return $images;
    }

    public function hasNewProcess($i){
        return $this->links[$i]['hasNewProcess'];
    }

    public function hasNewDanger($i){
        return $this->links[$i]['hasNewDanger'];
    }

    public function getProcessMax($i){
        return $this->getProcess($i)['max'];
    }

    public function getDangerMax($i){
       return  $this->getProcess($i)[$this->links[$i]['danger']]['max'];
    }

    public function getProcessName($i){
        $el = $this->getProcess($i)[0]['processName'];
        $el = $this->shrink($el);
        return $el;
    }

    public function getDangerName($i){
        $el = $this->getProcess($i)[0]['dangerName'];
        $el = $this->shrink($el);
        return $el;
    }

    public function getProcess($i){
        return $this->object[$this->links[$i]['process']];
    }

    public function getProcessId($i){
        return $this->links[$i]['process'];
    }
    public function getDanger($i){
        return $this->object[$this->links[$i]['danger']];
    }

    public function getDangerId($i){
        return  $this->links[$i]['danger'];
    }

    public function getElement($i){
        return $this->object[$this->links[$i]['element']];
    }

    public function getElementId($i){
        return $this->links[$i]['element'];
    }
}


