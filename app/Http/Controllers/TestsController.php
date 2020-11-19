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
//              $c->setElementImage('', '', '');
//              $c->saveData();
//
              dd('done');
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
