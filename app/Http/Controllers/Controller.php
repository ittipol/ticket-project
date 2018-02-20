<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $data = array();
  protected $pageName = null; 
  protected $meta = array(
    'title' => 'แหล่ง ซื้อ ขาย บัตร ตั๋ว วอชเชอร์ ได้ด้วยตัวคุณเอง — TicketEasys',
    'description' => 'เว็บไซต์ที่ให้คุณซื้อและขายบัตรงานแสดงต่างๆ ได้ด้วยตัวคุณเอง โดยคุณเป็นผู้ตั้งราคา',
    'image' => 'https://ticketeasys.com/assets/images/logo/logo_tn_l.jpg',
    'keywords' => 'ซื้อ,ขาย,บัตรคอนเสิร์ต,ตั๋ว,วอชเชอร์,voucher,ticket,deal,ดีล',
  );

  protected $botDisallowed = false;

  protected function botDisallowed() {
    $this->botDisallowed = true;
  }

  protected function setMeta($type,$value = null) {
    
    if(empty($value)) {
      return false;
    }

    $this->meta[$type] = $value;

  }

  protected function setData($index,$value) {
    $this->data[$index] = $value;
  }

  protected function error($message) {

    $data = array(
      'message' => $message
    );

    return view('errors.error',$data);
  }

  protected function view($view = null) {

    // Request::fullUrl()
    // Request::url()
    // Request::ip()

    $this->data['_pageName'] = $this->pageName;
    $this->data['_meta'] = $this->meta;
    $this->data['_bot'] = $this->botDisallowed;

    return view($view,$this->data);
  }
}
