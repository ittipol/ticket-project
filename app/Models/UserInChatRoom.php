<?php

namespace App\Models;

class UserInChatRoom extends Model
{
  protected $table = 'user_in_chat_room';
  protected $fillable = ['chat_room_id','user_id'];
}
