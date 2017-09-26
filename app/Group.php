<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

  public function messages()
  {
    return $this->hasMany('App\Message');
  }
  public function users()
  {
    return $this->belongsToMany('App\User');
  }

}
