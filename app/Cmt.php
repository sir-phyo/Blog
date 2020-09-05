<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cmt extends Model
{
    protected  $fillable = ['post_id', 'comment'];
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post1(){
        return $this->belongsTo('App\Post1');
    }

}
