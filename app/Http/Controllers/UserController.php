<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\library\service;
use Facebook\Facebook;
use App\library\token;
use App\library\snackbar;
use Auth;
use Hash;
use Redirect;

class UserController extends Controller
{
  public function login() {
    $this->setMeta('title','เข้าสู่ระบบ — TicketShare');
    return $this->view('pages.user.login');
  }

  public function authenticate() {

    if(Auth::attempt([
      'email' => request()->input('email'),
      'password' => request()->input('password'),
      'has_password' => 1
    ],!empty(request()->input('remember')) ? true : false)){

      $user = User::find(Auth::user()->id);
      $user->user_key = Token::generate(32);
      $user->save();

      Snackbar::message('เข้าสู่ระบบแล้ว');
      return Redirect::intended('/');
    }

    $message = 'อีเมล หรือ รหัสผ่านไม่ถูก';

    if(empty(request()->input('email')) && empty(request()->input('password'))) {
      $message = 'กรุณาป้อนอีเมล และ รหัสผ่าน';
    }

    Snackbar::message($message);

    return Redirect::back()->withErrors([$message]);

  }

  public function register() {
    return $this->view('pages.user.register');
  }

  public function registering(RegisterRequest $request) {

    // 2 pow rounds
    $hashed = Hash::make($request->password, [
        'rounds' => 12
    ]);

    $user = new User;
    $user->email = trim($request->email);
    $user->password = $hashed;
    $user->name = trim($request->name);
    $user->user_key = 1;
    $user->jwt_secret_key = Token::generate(32);
    $user->has_password = 1;

    if($user->save()) {
      session()->flash('register-success',true);
    }

    Snackbar::message('บัญชีของคุณถูกสร้างแล้ว');

    return Redirect::to('login');

  }

  public function socialCallback() {

    if(empty(request()->code)) {
      abort(404);
    }

    $fb = new \Facebook\Facebook([
      'app_id' => '227375124451364',
      'app_secret' => 'd9d3b4300ebf9d1839dad310d62295fd',
      'default_graph_version' => 'v2.9',
    ]);

    try {
      // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name,email', request()->code);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $_user = $response->getGraphUser();

    $user = User::select('id','email')->where([
      ['social_provider_id','=',1],
      ['social_user_id','=',$_user['id']],
    ])->first();

    if(empty($user)) {
      $user = new User;
      $user->social_provider_id = 1; // FB
      $user->social_user_id = $_user['id'];

      if(!empty($_user['email'])) {
        $user->email = $_user['email'];
      }

      $user->name = $_user['name'];
      $user->user_key = 1;
      $user->jwt_secret_key = Token::generate(32);
      $user->save();
    }

    Auth::login($user,true);

    Snackbar::message('เข้าสู่ระบบแล้ว');

    return Redirect::intended('/');

  }

  public function chat($ticketId) {

    $roomModel = Service::loadModel('ChatRoom');
    $messageModel = Service::loadModel('ChatMessage');
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
      $roomModel->room_key = Token::generate(128);
      $roomModel->save();

      $sellerChatRoomModel->chat_room_id = $roomModel->id;
      $sellerChatRoomModel->seller = $ticket->created_by;
      $sellerChatRoomModel->buyer = Auth::user()->id;
      $sellerChatRoomModel->save();
    }else{
      $roomModel = $roomModel->find($_room->chat_room_id);
    }

    $seller = User::select('id','name','avatar','online')->find($ticket->created_by);

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

    $this->setData('chat',json_encode($chat));
    $this->setData('seller',$seller->getAttributes());

    return $this->view('pages.user.chat');
  }

  public function logout() {
    
    if(Auth::check()) {
      Auth::logout();
      session()->flush();
    }

    return redirect('/');
  }

}