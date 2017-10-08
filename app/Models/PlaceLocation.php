<?php

namespace App\Models;

class PlaceLocation extends Model
{
  protected $table = 'place_locations';
  protected $fillable = ['name'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    $value = trim($value);

    $location = $this->select('id')->where('name','like',$value);

    if(!$location->exists()) {
      // Save
      $this->name = $value;
      $this->save();

    }

    return true;

  }
}
