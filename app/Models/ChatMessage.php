<?php

namespace App\Models;

class ChatMessage extends Model
{
  protected $table = 'chat_messages';
  protected $fillable = ['chat_room_id','user_id','message'];
}
