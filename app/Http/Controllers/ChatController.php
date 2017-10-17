<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\token;
use App\library\snackbar;
use Auth;
use Redirect;

class ChatController extends Controller
{
  public function sellerChat($ticketId) {

    $ticket = Service::loadModel('Ticket')->select('created_by')->find($ticketId);

    if(empty($ticket)) {
      Snackbar::message('ไม่พบรายการนี้');
      return Redirect::to('/ticket');
    }

    if(Auth::user()->id == $ticket->created_by) {
      Snackbar::message('ขออภัยคุณไมาสามารถคุยกับผู้ขายรายนี้ได้ คุณกับผู้ขายคือบุคคลเดียวกัน');
      return Redirect::to('/');
    }


    $room = Service::loadModel('TicketChatRoom')
    ->join('user_in_chat_room', 'ticket_chat_rooms.chat_room_id', '=', 'user_in_chat_room.chat_room_id')
    ->select('ticket_chat_rooms.chat_room_id')
    ->where([
      ['ticket_chat_rooms.ticket_id','=',$ticketId],
      ['user_in_chat_room.user_id','=',Auth::user()->id],
      ['user_in_chat_room.role','=','b'],
    ]);

    if($room->exists()) {
      // check has buyer in this room
      // Service::loadModel('UserInChatRoom')
      $room = Service::loadModel('ChatRoom')->select('id','room_key')->find($room->first()->chat_room_id);

    }else {
      $room = $this->createRoom($ticketId,$ticket->created_by);

    }

    $chat = array(
      'user' => Auth::user()->id,
      'room' => $room->id,
      'key' => $room->room_key,
      'page' => 1,
      'time' => date('Y-m-d H:i:s')
    );

    // Get Other users in room
    $_users = Service::loadModel('UserInChatRoom')->where([
      ['chat_room_id','=',$room->id],
      ['user_id','!=',Auth::user()->id]
    ])->get();

    $users = array();
    foreach ($_users as $user) {
      $users[] = Service::loadModel('User')->select('id','name','avatar','online')->find($user->user_id)->getAttributes();
    }

    $this->setData('chat',json_encode($chat));
    $this->setData('users',$users);

    return $this->view('pages.user.chat');
  }

  public function chatRoom($roomId) {

    $room = Service::loadModel('ChatRoom')->select('room_key')->find($roomId);

    if(empty($room)) {
      Snackbar::message('ไม่สามารถแชทได้');
      return Redirect::to('/');
    }

    // check user room
    $count = Service::loadModel('UserInChatRoom')->where([
      ['chat_room_id','=',$roomId],
      ['user_id','=',Auth::user()->id]
    ])->count();

    if(!$count) {
      Snackbar::message('ไม่สามารถแชทได้');
      return Redirect::to('/');
    }

    $chat = array(
      'user' => Auth::user()->id,
      'room' => $roomId,
      'key' => $room->room_key,
      'page' => 1,
      'time' => date('Y-m-d H:i:s')
    );

    // Get Other users in room
    $_users = Service::loadModel('UserInChatRoom')->where([
      ['chat_room_id','=',$roomId],
      ['user_id','!=',Auth::user()->id]
    ])->get();

    $users = array();
    foreach ($_users as $user) {
      $users[] = Service::loadModel('User')->select('id','name','avatar','online')->find($user->user_id)->getAttributes();
    }

    $this->setData('chat',json_encode($chat));
    $this->setData('users',$users);

    return $this->view('pages.user.chat');

  }

  private function createRoom($ticketId,$by) {
    // create new room
    $room = Service::loadModel('ChatRoom');
    $room->room_key = Token::generate(16);
    $room->save();

    // create room with this ticket
    $ticketChatRoom = Service::loadModel('TicketChatRoom');
    $ticketChatRoom->ticket_id = $ticketId;
    $ticketChatRoom->chat_room_id = $room->id;
    $ticketChatRoom->save();

    // Add user to chat room
    // Seller
    $_user = Service::loadModel('UserInChatRoom');
    $_user->chat_room_id = $room->id;
    $_user->user_id = $by;
    $_user->role = 's';
    $_user->save();

    // Buyer
    $_user = Service::loadModel('UserInChatRoom');
    $_user->chat_room_id = $room->id;
    $_user->user_id = Auth::user()->id;
    $_user->role = 'b';
    $_user->save();

    return $room;
  }
}
