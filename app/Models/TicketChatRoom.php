<?php

namespace App\Models;

class TicketChatRoom extends Model
{
  protected $table = 'ticket_chat_rooms';
  protected $fillable = ['chat_room_id','ticket_id'];

  public function setUpdatedAt($value) {}
}
