<?php

namespace App\Helperclass;

use App\Helperclass\Customizable;


class Texts extends SiteJson{

    public $elementsForPage = [];
    public $imagesForElement = [];

    public function __construct($code='inherit'){
        if ($code == 'inherit')
            parent::__construct();

        $this->init();
    }

    public function init(){
        $this->elementsForPage = [
            'home' => [
                'small-title', 'title', 'description'
            ],
            'about' => [
                'title',
                'title-1',
                'description-1',
                'title-2',
                'description-2'
            ],
            'contact' => [
                'title'
            ],
            'blogs' => [
                'title'
            ],
            'services' => [
                'title',
            ]
       ];
    }

    public function update($page, $elem, $style){
        if (in_array($elem, $this->elementsForPage[$page])){
            $this->data['texts'][$page][$elem] = $style;
            $this->saveData($this->data);
            return true;
        }

        return false;
   }


    public function getContent($page){
          return $this->getPageElements($page);
    }


    public function getText($page, $elem, $data){
          if (isset($data['texts'][$page][$elem])){
              return $data['texts'][$page][$elem]['value'];
          }

          return false;
    }


    public function getStyle($page, $elem, $data){
        if (isset($data['texts'][$page][$elem])){
             $style = [];

             $el = $data['texts'][$page][$elem];

             if ($el['is-bold']){
                 $style[] ='font-weight:bold;';
             }

             $style[] = "font-size: {$el['font-size']}rem;";  //

             $style[] = "color: {$el['color']};";   //

             return implode('',$style);
        }

        return "";
    }

    public function services(){
        return "";
    }


    public function pageElements($page){
          if (!isset($this->data['texts'][$page])){
              $this->data['texts'][$page] =
                   $this->createDefaultElements($this->elementsForPage[$page]);

              $this->saveData($this->data);
          }

          elseif (count($this->data['texts'][$page]) != count($this->elementsForPage[$page])){

              $elms = $this->createDefaultElements($this->elementsForPage[$page]);

              foreach ($this->data['texts'][$page] as $title => $style){
                  $elms[$title] = $style;
              }

              $this->data['texts'][$page] = $elms;
              $this->saveData($this->data);
          }

          return $this->data['texts'][$page];
    }

    public function createDefaultElements($els){
          $elements = [];

          foreach ($els as $element){
              $elements[$element] = $this->defaultConfiguration($element);
          }

          return $elements;
    }

    public function defaultConfiguration($element){
          return [
                   'is-bold' => false,
                   'font-size' => '1',
                   'color' => 'black',
                   'value' => ''
          ];
    }

    public function getElementImage($page,$element){
        return $this->data['element-images'][$page][$element] ?? '/icons/no-image.png';
    }

    public function setElementImage($page, $element, $src){
        if (!isset($this->data['element-images']))
            $this->data['element-images'] = [];

        if (!isset($this->data['element-images'][$page]))
            $this->data['element-images'][$page] = [];

        $this->data['element-images'][$page][$element] = $src;
    }
}




