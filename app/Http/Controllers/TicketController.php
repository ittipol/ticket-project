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

    $model = Service::loadModel('Ticket');
   
    $this->setData('dateType',$model->getDateType());

    $this->setMeta('title','เพิ่มรายการขาย — TicketSnap');
    return $this->view('pages.ticket.form.add');
  }

  public function addingSubmit() {

    // dd(request()->all());

    $model = Service::loadModel('Ticket');

    // create slug

    switch (request()->get('date_type')) {
      case 1:
        
        if(!empty(request()->get('date_1'))) {
          $model->date_1 = request()->get('date_1').' 00:00:00';
        }

        $model->date_2 = request()->get('date_2').' 23:59:59';

        break;
      
      case 2:
        $model->date_1 = request()->get('date_2').' 00:00:00';
        $model->date_2 = request()->get('date_2').' 23:59:59';
        break;

      case 3:
        $model->date_1 = request()->get('date_2').' 00:00:00';
        $model->date_2 = request()->get('date_2').' 23:59:59';
        break;
    }

    $model->title = request()->get('title');
    $model->description = request()->get('description');
    $model->place_location = request()->get('place_location');
    $model->price = request()->get('price');
    $model->original_price = request()->get('original_price');
    $model->date_type = request()->get('date_type');
   
    if(!$model->save()) {
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
