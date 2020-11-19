<?php

namespace App\Http\Controllers;

use App\Helperclass\Obj;
use App\Helperclass\Json;
use App\Helperclass\Content;
use App\Helperclass\SiteJson;
use App\Helperclass\Texts;
use App\Helperclass\Services;
use App\Helperclass\Customizable;
use App\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class TestsController extends Controller
{
      public function index(){

      //      $obj = new Customizable();

      //      dd($obj->getData());

            //  dd($this->getData());

//            $c = new SiteJson();
//
//            dd($c->getData());

//              $c = new Texts();
//
//              $data = $c->getData();
//              $data['element-images'] = [
//                  'home' => [
//                      'small-title' => '/element-images/home-small-title.png',
//                      'title' => '/element-images/home-title.png',
//                      'description' => '/element-images/home-description.png',
//                  ],
//                  'blogs' => [
//                      'title' => '/element-images/blogs-title.png'
//                  ],
//                  'services' => [
//                      'title' => '/element-images/service-title.png'
//                  ],
//                  'about' => [
//                      'title' => '/element-images/about-title.png',
//                      'title-1' => '/element-images/about-title-1.png',
//                      'description-1' => '/element-images/about-description-1.png',
//                      'title-2' => '/element-images/about-title-2.png',
//                      'description-2' => '/element-images/about-description-2.png',
//                  ],
//                  'contact' => [
//                      'title' => '/element-images/contact-title.png'
//                  ]
//              ];
//
//              $c->saveData($data);
//
//              dd($c->getData());

                dd('Hi, over there');

//              $c->setElementImage('', '', '');
//              $c->saveData();
//
//              dd($c->getElementImage('home', 'title'));
      }

      public function getData(){

            $data = [];

            foreach (['1','2', '3_123'] as $val){
                   $data[$val] = $this->anotherFn($val);
            }

            return $data;
      }

      public function anotherFn($el){
            return
                   [
                        'is-bold' => 'yes'
                   ];

      }
}
