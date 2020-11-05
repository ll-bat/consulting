<?php

namespace App\Helperclass;

use App\Modification;
use App\Helperclass\Texts;
use App\Helperclass\Services;

class Customizable extends SiteJson{

      public $texts = null;
      public $services = null;
      public $pages = ['home', 'blogs', 'about', 'services', 'contact'];

      public function __construct($type='inherit'){
           parent::__construct();

           $this->texts = new Texts($type);
           $this->services = new Services();
      }


      public function getImage($name){
          if (isset($this->data['images'][$name])) {
              return $this->data['images'][$name];
          }

          return "";
      }

      public function hasImage($name){
          $image = $this->getImage($name);

          if ($image != "") return true;

          return false;
      }

      public function getImageName($name){
          $name = explode('.', $name)[1];

          if ($this->hasImage($name)) 
              return $this->getImage($name);
          return "/storage/icons/no-image.png";
      }

      public function getContentFor($name){
          if (!in_array($name, $this->pages)){
              return null;
          }

          return $this->texts->getContent($name);
      }

      public function getTextFor($page, $element){
          return $this->texts->getText($page, $element, $this->data);
      }

      public function getStyleFor($page, $element){
        return $this->texts->getStyle($page, $element, $this->data);
    }
}



