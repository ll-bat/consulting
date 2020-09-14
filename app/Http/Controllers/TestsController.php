<?php

namespace App\Http\Controllers;

use App\Helperclass\Obj;
use App\Helperclass\Content;
use App\Export;
use Illuminate\Http\Request;

class TestsController extends Controller
{
      public function index(){
          $export = Export::first();

          $con  = new Content($export->filename);
          $con = $con->getData();

          $obj  = $con[1];

          $obj->getImageContent(0);
      }
}
