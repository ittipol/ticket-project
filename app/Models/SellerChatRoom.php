<?php

namespace App\Models;

class SellerChatRoom extends Model
{
  protected $table = 'seller_chat_rooms';
  protected $fillable = ['chat_room_id','seller','buyer'];
  
  public $timestamps  = false;

}
