<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

  protected $fillable = ['name'];

  public function user()
  {
    return $this->belongsTo('App\User');
  }

  public function groups()
  {
    return $this->belongsToMany('App\Group');
}
  public function msgM()
  {
    return $this->hasMany('App\MessagePhotos');
  }
  //
}
