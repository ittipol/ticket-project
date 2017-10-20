<?php

namespace App\Models;

class TicketCategoryPath extends Model
{
  protected $table = 'ticket_category_paths';
  protected $fillable = ['ticket_category_id','path_id','level'];
  public $timestamps  = false;
}
