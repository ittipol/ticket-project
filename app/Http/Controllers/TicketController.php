<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\Snackbar;
use Illuminate\Http\Request;
use Redirect;
use Auth;

class TicketController extends Controller
{
  public function listView() {

    // GET Ticket
    $model = Service::loadModel('Ticket');

    // if(!empty(request()->q)) {
    //   $conditions[] = array('name','=','%'.request()->q.'%');
    // }

    // if(!empty($conditions)) {
    //   $data = $model->where($conditions)->paginate(24);
    // }else{
    //   $data = $model->paginate(24);
    // }

    $data = $model->orderBy('created_at','desc')->take(24)->get();

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

    $this->setMeta('title','เพิ่มรายการ — TicketSnap');
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
    $model->contact = request()->get('contact');
    $model->purpose = 's';
   
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

    Snackbar::message('เพิ่มรายการแล้ว');
    return Redirect::to('ticket/view/'.$model->id);
    
  }

  public function edit($ticketId) {

    $model = Service::loadModel('Ticket')->find($ticketId);

    if(empty($model) || ($model->created_by != Auth::user()->id)) {
      Snackbar::message('ไม่สามารถแก้ไขรายการนี้ได้');
      return Redirect::to('/ticket');
    }

    $_images = $model->getRelatedData('Image',array(
      'fields' => array('id','model','model_id','filename','description','image_type_id')
    ));

    $images = array();
    if(!empty($_images)) {
      foreach ($_images as $image) {
        $images[] = $image->buildFormData();
      }
    }

    $this->setData('data',$model);
    $this->setData('images',json_encode($images));

    $this->setData('dateType',$model->getDateType());

    $this->setMeta('title','แก้ไขรายการ — TicketSnap');

    return $this->view('pages.ticket.form.edit');
  }

  public function editingSubmit($ticketId) {

    $model = Service::loadModel('Ticket')->find($ticketId);

    if(empty($model) || ($model->created_by != Auth::user()->id)) {
      Snackbar::message('ไม่สามารถแก้ไขรายการนี้ได้');
      return Redirect::to('/ticket');
    }

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
dd(request()->all());
    $model->title = request()->get('title');
    $model->description = request()->get('description');
    $model->place_location = request()->get('place_location');
    $model->price = request()->get('price');
    $model->original_price = request()->get('original_price');
    $model->date_type = request()->get('date_type');
    $model->contact = request()->get('contact');
    $model->purpose = 's';
    
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

    Snackbar::message('แก้ไขรายการแล้ว');
    return Redirect::to('ticket/view/'.$model->id);
  }

  public function detail($ticketId) {

    $model = Service::loadModel('Ticket')->find($ticketId);

    if(empty($model)) {
      Snackbar::message('ไม่พบรายการนี้');
      return Redirect::to('/ticket');
    }

    // GET SELLER
    $seller = Service::loadModel('User')->select('name','avatar','online')->find($model->created_by);

    $this->setData('data',$model->buildDataDetail());
    $this->setData('seller',$seller->getAttributes());
    $this->setData('ticketId',$ticketId);

    // SET META
    $this->setMeta('title',$model->title);
    $this->setMeta('description','');
    $this->setMeta('image',null);

    return $this->view('pages.ticket.detail');

  }
}
