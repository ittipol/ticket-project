<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $fillable = ['title','description','place_location','price','original_price','expiration_date','created_by'];
}
