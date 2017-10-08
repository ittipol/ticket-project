<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\library\service;
use Facebook\Facebook;
use App\library\token;
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
      return Redirect::intended('/');
    }

    $message = 'อีเมล หรือ รหัสผ่านไม่ถูก';

    if(empty(request()->input('email')) && empty(request()->input('password'))) {
      $message = 'กรุณาป้อนอีเมล และ รหัสผ่าน';
    }

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
    $user->user_key = Token::generateSecureKey();
    $user->has_password = 1;

    if($user->save()) {
      session()->flash('register-success',true);
    }

    return Redirect::to('login');

  }

  public function logout() {
    
    if(Auth::check()) {
      Auth::logout();
      session()->flush();
    }

    return redirect('/');
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

      $user->user_key = Token::generateSecureKey();

      $user->save();
    }

    Auth::login($user,true);

    return Redirect::intended('/');

  }

}