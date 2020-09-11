<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Export extends Model
{
      public $table = 'exports';
      public $fillable = ['user_id', 'filename'];

      public function path(){
          return 'exports/'.$this->filename;
      }
}
