<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessagePhotos extends Model
{
  protected $fillable = ['messsage_id', 'filename'];

  public function msg()
  {
      return $this->belongsTo('App\Message');
  }
}
