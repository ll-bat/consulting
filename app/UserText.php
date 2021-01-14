<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserText extends Model
{
     protected $fillable = ['user_id','danger_id', 'name', 'type'];
}
