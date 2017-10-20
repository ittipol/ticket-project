<?php

namespace App\Models;

class TicketCategory extends Model
{
  protected $table = 'ticket_categories';
  protected $fillable = ['parent_id','name','description','active'];
  public $timestamps  = false;
}
