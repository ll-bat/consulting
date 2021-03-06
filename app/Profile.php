<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function pathAvatar(){
        $path = $this->avatar ?? '';
        if ($path == '') return '/icons/user_1.png';
        // return asset('storage/'.$path);
        return $path;
    }

    public function pathBack(){
        $path = $this->background ?? '';
        if ($path == '') $path = '/backgrounds/background.png';
        // return asset('storage/'.$path);
        return $path;
    }
}
