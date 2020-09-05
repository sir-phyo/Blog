<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post1 extends Model
{
    //table name
  //  protected $table = 'post1s';
    //primary key
    //public $primaryKey='id';
    //timestamps
    // public $timestamps=false;
    public function user(){
      return $this->belongTo('App\user');
    }
    public function cmt(){
        return $this->hasMany('App\Cmt','post_id');
    }
}
