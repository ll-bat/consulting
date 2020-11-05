<?php

namespace App\Helperclass;


use App\Helperclass\SiteJson;

class Services extends SiteJson{

    private $services = null;

    public function __construct($code='inherit'){
         if ($code == 'inherit'){
             parent::__construct();
         }
         $this->init();
    }

    public function init(){
         if (isset($this->data['services'])){
             $this->services = $this->data['services'];
         }
         else {
             $this->createDefaultServices(['service 1', 'service 2', 'service 3']);
         }
    }

    public function getServices(){
        return $this->services;
    }

    public function getJson(){
        return json_encode($this->getServices());
    }

    public function whereShown(){
        return array_filter($this->services, function($service){
            return $service['shown'] == 'true';
        });
    }

    public function update($id, $obj){
        $this->data['services'][$id] = $obj;
        $this->saveData($this->data);
    }

    public function delete($id){        
        if ($this->services[$id]){
            unset($this->services[$id]);
            $this->data['services'] = $this->services;
            $this->saveData($this->data);
            return 'Deleted';
        }
        return 'Not found';
    }

    public function create($id){
        $this->services[$id] = $this->createDefaultService();

        $this->data['services'] = $this->services;
        $this->saveData($this->data);
    }
    
    public function createDefaultServices($services){
        foreach ($services as $ind => $service){
             $this->services[strval($ind+1)] = $this->createDefaultService($service);
        }

        $this->data['services'] = $this->services;
        $this->saveData($this->data);
    }

    public function createDefaultService($service=""){
        return [
             'image' => '/icons/no-image.png',
             'title' => $service,
             'description' => '',
             'shown' => 'false'
        ];
    }
}



