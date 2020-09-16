<?php

namespace App\Http\Controllers;

use App\Helperclass\Obj;
use App\Helperclass\Content;
use App\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class TestsController extends Controller
{
      public function index(){
          
          $data = [];
          $ch = call_user_func([static::class, 'isString'], $data);
          dd($ch);

      }

      public function isString($val){ 
            return is_string($val);
      }
}
