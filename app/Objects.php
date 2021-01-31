<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Objects
 * @package App
 * @property integer $id
 * @property string $name
 */
class Objects extends Model
{
    protected $fillable = ['user_id', 'name'];
}
