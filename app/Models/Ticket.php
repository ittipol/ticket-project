<?php

namespace App\Models;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $fillable = ['title','description','place_location','price','original_price','start_date','expiration_date','created_by'];

  public $imageTypeAllowed = array(
    'photo' => array(
      'limit' => 10
    )
  );
}
