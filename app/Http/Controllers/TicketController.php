<?php

namespace App\Http\Controllers;

use App\library\service;
use Illuminate\Http\Request;

class TicketController extends Controller
{
  public function add() {
    // concert
    $this->setMeta('title','เพิ่มรายการขาย — TicketSnap');
    return $this->view('pages.ticket.form.add');
  }

  public function addingSubmit() {

    dd(request()->all());

    $model = Service::loadModel('Ticket');

    // if(!empty(request()->_images)) {

    //   $images = array();
    //   foreach (request()->_images as $value) {
        
    //     if(empty($value)) {
    //       continue;
    //     }

    //     $images[] = $value;

    //   }

    //   if(!empty($images)) {
    //     $model->images = json_encode($images);
    //   }

    // }
    
    if($model->fill(request()->all())->save()) {
      dd('save');
      return Redirect::to('admin/charity/list');
    }

    return Redirect::back();
  }
}
