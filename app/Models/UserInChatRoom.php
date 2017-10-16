<?php

namespace App\Models;

class UserInChatRoom extends Model
{
  protected $table = 'user_in_chat_room';
  protected $fillable = ['chat_room_id','user_id','notify','message_read','message_read_date'];
  public $timestamps  = false;

  public function chatRoom() {
    return $this->hasOne('App\Models\ChatRoom','id','chat_room_id');
  }

  public function user() {
    return $this->hasOne('App\Models\user','id','user_id');
  }

}
