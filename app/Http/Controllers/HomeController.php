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
      $value->activated_date = $value->created_at->format('Y-m-d H:i:s');
      $value->save();
    }

    dd('done');

  }
}
