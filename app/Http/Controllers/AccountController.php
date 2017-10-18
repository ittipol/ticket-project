<?php

namespace App\Http\Controllers;

use App\library\service;
use Auth;
use Redirect;

class AccountController extends Controller
{
  public function edit() {
    dd('xxx');

    $$this->setData('data',Service::loadModel('User')->find(Auth::user()->id));

    $this->setMeta('title','แก้ไขโปรไฟล์');

    return $this->view('page.account.profile_edit');

  }
}
