<?php

namespace App\Http\Controllers;

use App\library\service;

class HomeController extends Controller
{
  public function index() {

    // $this->botDisallowed();

    return $this->view('pages.home.index');
  }

  public function _checkPost() {

    $data = Service::loadModel('Ticket')->get();

    foreach ($data as $value) {
      dd($value->created_at);
      $value->activated_date = $value->created_at;
      $value->save();
    }

  }
}
