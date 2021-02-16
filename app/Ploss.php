<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ploss extends Model
{
      protected $fillable = ['name', 'k', 'field_id'];
      public const k = 3;
}
