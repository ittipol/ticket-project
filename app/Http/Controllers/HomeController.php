<?php

namespace App\Http\Controllers;

// use App\library\service;

class HomeController extends Controller
{
  public function index() {

    $this->botDisallowed();

    return $this->view('pages.home.index');
  }
}
