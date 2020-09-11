<?php

namespace App\Helperclass;


class Obj {

    protected $object  = null;
    protected $links  = null;
    protected $all    = null;

    public function __construct($data, $links, $all){
        $this->setData($data,$links,$all);
    }

    public function setData($data,$links,$all){
        $this->object  = $data;
        $this->links = $links;
        $this->all   = $all;
    }


    public function getData(){
        return [$this->object, $this->links, $this->all];
    }


    public function getObject($i){
        $pid = $this->getProcessId($i);
        $did = $this->getDangerId($i);

        return $this->object[$pid][$did]['data'];
    }


    public function getArrayElement($name, $i){
        $obj = $this->getObject($i);
        $elm = $this->getElementId($i);

        $el = $this->getExactElement($obj,$name, $elm);

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

        if ($el != '') return $el; 
        return '----';
    }

    public function getControl($type,$i){
        $obj = $this->getObject($i);
        $elm = $this->getElementId($i);

        $controls = &$obj['control'];

        if (count($controls[$type]) > $elm){
            return $controls[$type][$elm]['model']['name'];
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
    }

    public function getImageName($i){
        $obj = $this->getObject($i);
        return '/storage/'.$obj['imageName'];
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
        return $this->getProcess($i)[0]['processName'];
    }

    public function getDangerName($i){
        return $this->getProcess($i)[0]['dangerName'];
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



