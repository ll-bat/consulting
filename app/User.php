<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Mpdf\Tag\U;

class User extends Authenticatable
{
    use Notifiable;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const TYPE_STANDARD = 0;
    public const TYPE_PREMIUM = 1;
    public const TYPE_VIP = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'status', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(){
        return $this->is_admin == 1;
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function pathAvatar(){
        return $this->profile->pathAvatar();
    }


}
