<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //relacja z modelem user
    public function user(){
        return $this->belongsTo('App\User');
    }

    //relacja z modelem likes - hasMany
    public function likes(){
        return $this->hasMany('App\likePost', 'post_id');
    }

    //relacja z modelem comments - hasMany
    public function comments(){
        return $this->hasMany('App\comments', 'post_id');
    }

    //relacja z modelem posts-links
    public function postsLinks(){
        return $this->hasMany('App\PostsLinks', 'post_id');
    }
}
