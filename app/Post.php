<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public  function user(){
        return $this->belongsTo(user::class)->select(['id','name','image']);
    }
    public function likes(){
        return $this->belongsToMany(user::class,'likes','post_id','user_id')->select(['post_id','user_id','name']);
    }
    public function comments(){
        return $this->hasMany(comment::class);
    }
}
