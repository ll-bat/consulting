<?php

namespace App\Helperclass;

use App\Modification;

class SiteJson {

    protected $data = [];
    
    public function __construct(){
        if (Modification::count() == 0){
            Modification::create(['data' => "[]"]);
        }
        else {
            $data = Modification::first();
            $this->data = json_decode($data['data'],true);
        }
    }

    public function saveData($data){
        $this->data = $data;
        
        $data = json_encode($data);

        Modification::first()->update(['data' => $data]);
   }

   public function getData(){
       return $this->data;
   }

   public function siteLogo(){
       if (isset($this->data['images'])){
           if (isset($this->data['images']['logo']))
              return $this->data['images']['logo'];
       }
       return '/icons/no-image.pdf';
   }
}



