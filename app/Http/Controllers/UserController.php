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
    $this->setMeta('title','เข้าสู่ระบบ — TicketSnap');
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

      Snackbar::message('คุณได้เข้าสู่ระบบแล้ว');
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

    if(empty(request()->code)) {
      abort(404);
    }

    $fb = new \Facebook\Facebook([
      'app_id' => env('FB_APP_ID'),
      'app_secret' => env('FB_SECRET_ID'),
      'default_graph_version' => env('GRAPH_VERSION'),
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
      $user->user_key = Token::generate(32);
      $user->jwt_secret_key = Token::generate(32);
      $user->save();
    }

    Auth::login($user,true);

    Snackbar::message('คุณได้เข้าสู่ระบบแล้ว');

    return Redirect::intended('/ticket');

  }

  public function logout() {
    
    if(Auth::check()) {

      $user = User::find(Auth::user()->id);
      $user->online = 0;
      $user->save();

      Auth::logout();
      session()->flush();
    }

    return redirect('/');
  }

}