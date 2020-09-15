<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function isLiked(){
        return $this->is_liked == 1;
    }
    public function state(bool $s){
        $this->is_liked = $s;
        $this->save();
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function blog(){
        return $this->belongsTo(Blog::class);
    }
    public function postDate(){
       return  $this->created_at->format('d M, yy');
    }

}
