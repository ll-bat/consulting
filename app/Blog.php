<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = ['user_id', 'title','category_id', 'excerpt' ,'body', 'image'];

    public function path(){
        if ($this->image == '')
             return testBack();
        return asset('storage/'.$this->image);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function getLastThree(){
        return Comment::where('blog_id', $this->id)->latest()->take(3)->get()->reverse();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function isPublic(){
        return $this->is_public === 1;
    }
    public function togglePublic(){
        if ($this->isPublic())
            $this->is_public = 0;
        else
            $this->is_public = 1;
        $this->save();
    }

    public function getDay(){
        return  $this->created_at->format('d');
    }
    public function getMonth(){
        return  $this->created_at->format('M');
    }
    public function postDate(){
        return  $this->created_at->format('d M, yy');
    }
}
