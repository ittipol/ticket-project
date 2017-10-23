<?php

namespace App\Http\Controllers;

// use App\library\service;

class HomeController extends Controller
{
  public function index() {

    $this->setMeta('title','Ticket');

    // $this->setData('categories',Service::loadModel('TicketCategory')->get());
    
    return $this->view('pages.home.index');
  }
}
