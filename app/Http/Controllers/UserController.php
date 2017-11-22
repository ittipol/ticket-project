<?php

namespace App\Http\Controllers;

// use Facebook\Facebook;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\library\service;
use App\library\token;
use App\library\snackbar;
use Auth;
use Hash;
use Redirect;

class UserController extends Controller
{
  public function login() {
    $this->setMeta('title','เข้าสู่ระบบ — TicketEasys');
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

      // User log
      Service::addUserLog('User',Auth::user()->id,'login');

      Snackbar::message($this->welcomeMessage());
      return Redirect::intended('/ticket');
    }

    $message = 'อีเมล หรือ รหัสผ่านไม่ถูก';

    if(empty(request()->input('email')) && empty(request()->input('password'))) {
      $message = 'กรุณาป้อนอีเมล และ รหัสผ่าน';
    }

    // Snackbar::message($message);

    return Redirect::back()->withErrors([$message]);
  }

  public function register() {
    $this->setMeta('title','เข้าสู่ระบบ');
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
    $user->user_key = Token::generate(32);
    $user->jwt_secret_key = Token::generate(32);
    $user->has_password = 1;

    if($user->save()) {
      session()->flash('register-success',true);
    }

    Snackbar::message('บัญชีของคุณถูกสร้างแล้ว คุณสามารถใช้บัญชีนี้เพื่อเข้าสู่ระบบ');

    return Redirect::to('login');
  }

  public function socialCallback() {

    if(!request()->has('code')) {
      abort(405);
    }

    // $fb = new Facebook([
    //   'app_id' => env('FB_APP_ID'),
    //   'app_secret' => env('FB_SECRET_ID'),
    //   'default_graph_version' => env('GRAPH_VERSION'),
    // ]);

    // try {
    //   // Returns a `Facebook\FacebookResponse` object
    //   $response = $fb->get('/me?fields=id,name,email', request()->code);
    // } catch(Facebook\Exceptions\FacebookResponseException $e) {
    //   // echo 'Graph returned an error: ' . $e->getMessage();
    //   abort(405);
    // } catch(Facebook\Exceptions\FacebookSDKException $e) {
    //   // echo 'Facebook SDK returned an error: ' . $e->getMessage();
    //   abort(405);
    // }

    $response = Service::facebookGetUserProfile(request()->code);

    if($response === false) {
      abort(405);
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
      $user->user_key = Token::generate(32);
      $user->jwt_secret_key = Token::generate(32);
      $user->save();
    }

    Auth::login($user,true);

    // User log
    Service::addUserLog('User',Auth::user()->id,'login (Facebook)');

    Snackbar::message($this->welcomeMessage());

    return Redirect::intended('/ticket');
  }

  public function logout() {

    if(Auth::check()) {
      $uid = Auth::user()->id;

      // $user = User::find(Auth::user()->id);
      // $user->online = 0;
      // $user->save();

      // Update last_active
      Auth::user()->last_active = date('Y-m-d H:i:s');
      Auth::user()->save();

      Auth::logout();
      session()->flush();

      Redis::del('user-online:'.$uid);

      Service::addUserLog('User',$uid,'logout',$uid);
    }

    return redirect('/');
  }

  private function welcomeMessage() {

    if(!empty(Auth::user()->last_active)) {

      $time = strtotime(date('Y-m-d H:i:s')) - strtotime(Auth::user()->last_active);

      if($time < (86400 * 5)) {
        return 'ยินดีต้อนรับ คุณได้เข้าสู่ระบบแล้ว';
      }elseif($time < (86400 * 10)) {
        return 'ไม่ได้เจอนานเลย!!! ยินดีต้อนรับ';
      }elseif($time < (86400 * 25)) {
        return 'นานมากแล้วที่คุณไม่ได้เข้ามาใช้งาน ยินดีต้อนรับ';
      }else {
        return 'นึกว่าลืมกันซะแล้ว ยินดีต้อนรับ';
      }
    }

    return 'ยินดีต้อนรับ ผู้ใช้ใหม่ <a href="/features">คุณสมบัติที่น่าสนใจ</a>';

  }

}