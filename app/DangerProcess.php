<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DangerProcess extends Model
{
      protected $table = 'danger_process';
      protected $fillable = ['danger_id', 'process_id'];
}
