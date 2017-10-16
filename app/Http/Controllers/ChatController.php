<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\token;
use App\library\snackbar;
use Auth;
use Redirect;

class ChatController extends Controller
{
  public function chat($ticketId) {

    $roomModel = Service::loadModel('ChatRoom');
    // $messageModel = Service::loadModel('ChatMessage');
    $sellerChatRoomModel = Service::loadModel('SellerChatRoom');

    $ticket = Service::loadModel('Ticket')->select('created_by')->find($ticketId);

    if(empty($ticket)) {
      Snackbar::message('ไม่พบรายการนี้');
      return Redirect::to('/ticket');
    }

    if(Auth::user()->id == $ticket->created_by) {
      Snackbar::message('ขออภัยคุณไมาสามารถคุยกับผู้ขายรายนี้ได้ คุณกับผู้ขายคือบุคคลเดียวกัน');
      return Redirect::to('/');
    }

    // check seller and buyer
    $_room = $sellerChatRoomModel->where([
      ['seller','=',$ticket->created_by],
      ['buyer','=',Auth::user()->id]
    ])->first();

    if(empty($_room)) {
      // Create room
      $roomModel->room_key = Token::generate(32);
      $roomModel->save();

      $sellerChatRoomModel->chat_room_id = $roomModel->id;
      $sellerChatRoomModel->seller = $ticket->created_by;
      $sellerChatRoomModel->buyer = Auth::user()->id;
      $sellerChatRoomModel->save();

      // Push user to chat room
      $_user = Service::loadModel('UserInChatRoom');
      $_user->chat_room_id = $roomModel->id;
      $_user->user_id = $ticket->created_by;
      $_user->save();

      $_user = Service::loadModel('UserInChatRoom');
      $_user->chat_room_id = $roomModel->id;
      $_user->user_id = Auth::user()->id;
      $_user->save();

    }else{
      $roomModel = $roomModel->find($_room->chat_room_id);
    }

    $chat = array(
      'user' => Auth::user()->id,
      // 'user' => {
      //   'id' => Auth::user()->id,
      //   'name' => Auth::user()->name,
      //   'avatar' => Auth::user()->avatar
      // },
      'room' => $roomModel->id,
      'key' => $roomModel->room_key,
      'page' => 1,
      'time' => date('Y-m-d H:i:s')
    );

    // Get Other users in room
    $_users = Service::loadModel('UserInChatRoom')->where([
      ['chat_room_id','=',$roomModel->id],
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
    $in = Service::loadModel('UserInChatRoom')->where([
      ['chat_room_id','=',$roomId],
      ['user_id','=',Auth::user()->id]
    ])->count();

    if(!$in) {
      Snackbar::message('ไม่สามารถแชทได้');
      return Redirect::to('/');
    }

    $chat = array(
      'user' => Auth::user()->id,
      // 'user' => {
      //   'id' => Auth::user()->id,
      //   'name' => Auth::user()->name,
      //   'avatar' => Auth::user()->avatar
      // },
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
}
