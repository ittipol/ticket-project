<?php

namespace App\Http\Controllers;

use App\library\service;
use Illuminate\Http\Request;
use Redirect;

class TicketController extends Controller
{
  public function listView() {

    // GET Ticket
    $model = Service::loadModel('Ticket');

    $data = $model->orderBy('created_at','desc')->get();

    $list = array();
    foreach ($data as $value) {
      $list[] = $value->buildDataList();
    }

    $this->setData('list',$list);

    return $this->view('pages.ticket.list');
  }

  public function add() {
    // concert
    $this->setMeta('title','เพิ่มรายการขาย — TicketSnap');
    return $this->view('pages.ticket.form.add');
  }

  public function addingSubmit() {

    // dd(request()->get('place_location'));

    $model = Service::loadModel('Ticket');

    //slug
    
    if(!$model->fill(request()->all())->save()) {
      return Redirect::back();
    }

    // Tagging
    if(!empty(request()->get('Tagging'))) {
      $taggingModel = Service::loadModel('Tagging');
      $taggingModel->__saveRelatedData($model,request()->get('Tagging'));
    }

    // images
    if(!empty(request()->get('Image'))) {
      $imageModel = Service::loadModel('Image');
      $imageModel->__saveRelatedData($model,request()->get('Image'));
    }

    // save Place location
    if(!empty(request()->get('place_location'))) {
      $placeLocationModel = Service::loadModel('PlaceLocation');
      $placeLocationModel->__saveRelatedData($model,request()->get('place_location'));
    }
    // Lookup

    return Redirect::to('ticket/view/'.$model->id);
    
  }
}
