<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\library\service;
use App\library\snackbar;
use Illuminate\Http\Request;
use Redirect;
use Auth;

class TicketController extends Controller
{
  public function listView() {

    $model = Service::loadModel('Ticket');

    $currentPage = 1;
    if(request()->has('page')) {
      $currentPage = request()->page;
    }
    //set page
    Paginator::currentPageResolver(function() use ($currentPage) {
        return $currentPage;
    });

    // dd(request()->all());

    $model = $model->query();

    if(request()->has('q')) {

      $_q = preg_replace('/\s[+\'\'\\\\\/:;()*\-^&!<>\[\]\|]\s/', ' ', trim(request()->q));
      $_q = preg_replace('/\s{1,}/', ' ', $_q);

      // $words = explode(' ', $_q);

      $keywords = array();
      $wordIds = array();

      foreach (explode(' ', $_q) as $word) {

        $word = str_replace(array('\'','"'), '', $word);
        $word = str_replace('+', ' ', $word);

        $len = mb_strlen($word);

        if($len < 2) {
          continue;
        }else{

          $keywords[] = array('title','like','%'.$word.'%');
          $keywords[] = array('description','like','%'.$word.'%');
          $keywords[] = array('place_location','like','%'.$word.'%');

          $_word = Service::loadModel('Word')->select('id')->where('word','like',$word);
          if($_word->exists()) {
            $wordIds[] = $_word->first()->id;
          }
        }
      }

      $model->where(function ($query) use ($keywords) {
        foreach ($keywords as $keyword) {
          $query->orWhere($keyword[0], $keyword[1], $keyword[2]);
        }
      });

      if(!empty($wordIds)) {
        $model
        ->join('taggings', 'taggings.model_id', '=', 'tickets.id')
        ->where(function ($query) use ($wordIds) {
          $query
          ->where('taggings.model_id','=','Ticket')
          ->whereIn('taggings.word_id',$wordIds,'or');
        });
      }
    }

    if(request()->has('price')) {
      $model->whereBetween('tickets.price', explode(',', request()->price));
    }

    if(request()->has('category')) {
      $model
      ->join('ticket_to_categories', 'ticket_to_categories.ticket_id', '=', 'tickets.id')
      ->whereIn('ticket_to_categories.ticket_category_id',request()->get('category'));
    }

    if(request()->has('startDate') || request()->has('endDate')) {

      $date = array();

      // startDate < value
      // endDate > value

      // startDate < value < endDate

      if(request()->has('startDate')) {
        $_date[] = array(
          'tickets.date_1', 
          array(request()->startDate,request()->endDate)
        );
      }

      if(request()->has('endDate')) {
        $date[] = array(
          'tickets.date_2', 
          array(request()->startDate,request()->endDate)
        );
      }

      $model->where(function ($query) use ($date) {
        foreach ($date as $value) {
          $query->orWhereBetween($value[0], $value[1]);
        }
      });
    }
dd($model);
    $data = $model
    ->where(function($q) {
      $q->where([
        ['closing_option','=',0],
        // ['date_2','>=',date('Y-m-d')]
      ]);
    })
    ->orderBy('tickets.created_at','desc')
    ->paginate(24);

    $this->setData('data',$data);

    $this->setData('categories',Service::loadModel('TicketCategory')->get());
    $this->setData('search',true);

    $this->setMeta('title','รายการขาย');

    return $this->view('pages.ticket.list');
  }

  public function detail($ticketId) {

    $model = Service::loadModel('Ticket')->where([
      ['id','=',request()->ticketId],
      ['closing_option','=',0]
    ])->first();

    if(empty($model)) {
      Snackbar::message('ไม่พบรายการนี้');
      return Redirect::to('/ticket');
    }

    // GET SELLER
    $seller = Service::loadModel('User')->select('name','avatar','online','last_active')->find($model->created_by);

    $data = $model->buildDataDetail();

    $keywords = array();
    foreach ($data['tags'] as $tag) {
      $keywords[] = $tag['word'];
    }

    $this->setData('data',$data);
    $this->setData('seller',$seller->buildDataDetail());
    $this->setData('ticketId',$ticketId);

    $this->setData('_text',$data['title']);

    // SET META
    $this->setMeta('title',$model->title);
    $this->setMeta('description','');
    $this->setMeta('image',null);
    $this->setMeta('keywords',implode(',',$keywords));

    return $this->view('pages.ticket.detail');

  }

  public function add() {

    $model = Service::loadModel('Ticket');

    $this->setData('categories',Service::loadModel('TicketCategory')->get());
    $this->setData('dateType',$model->getDateType());

    $this->setMeta('title','ขายบัตร — TicketSnap');

    return $this->view('pages.ticket.form.add');
  }

  public function addingSubmit() {

    dd(request()->all());

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

    // Add category to ticket
    if(!empty(request()->get('TicketToCategory'))) {
      Service::loadModel('TicketToCategory')->__saveRelatedData($model,request()->get('TicketToCategory'));
    }

    // Tagging
    if(!empty(request()->get('Tagging'))) {
      Service::loadModel('Tagging')->__saveRelatedData($model,request()->get('Tagging'));
    }

    // images
    if(!empty(request()->get('Image'))) {
      Service::loadModel('Image')->__saveRelatedData($model,request()->get('Image'));
    }

    // save Place location
    if(!empty(request()->get('place_location'))) {
      Service::loadModel('PlaceLocation')->__saveRelatedData($model,request()->get('place_location'));
    }
    // Lookup

    Snackbar::message('เพิ่มรายการแล้ว');
    return Redirect::to('ticket/view/'.$model->id);
    
  }

  public function edit($ticketId) {

    $model = Service::loadModel('Ticket')->where([
      ['id','=',$ticketId],
      ['closing_option','=',0],
      ['created_by','=',Auth::user()->id]
    ])->first();

    if(empty($model)) {
      Snackbar::message('ไม่สามารถแก้ไขรายการนี้ได้');
      return Redirect::to('/ticket');
    }

    $ticketCategoryId = null;

    $_ticketCategoryId = $model->getRelatedData('TicketToCategory',array(
      'fields' => array('ticket_category_id'),
      'first' => true
    ));

    if(!empty($_ticketCategoryId)) {
      $ticketCategoryId = $_ticketCategoryId->ticket_category_id;
    }

    $taggings = $model->getRelatedData('Tagging', array(
      'fields' => array('word_id')
    ));

    $words = array();
    foreach ($taggings as $tagging) {
      $words[] = $tagging->buildFormData();
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

    $model['TicketToCategory'] = array(
      'ticket_category_id' => $ticketCategoryId
    );

    $this->setData('data',$model);
    $this->setData('images',json_encode($images));
    $this->setData('taggings',json_encode($words));
    $this->setData('categories',Service::loadModel('TicketCategory')->get());
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

    // switch (request()->get('date_type')) {
    //   case 1:
        
    //     if(!empty(request()->get('date_1'))) {
    //       $model->date_1 = request()->get('date_1').' 00:00:00';
    //     }

    //     $model->date_2 = request()->get('date_2').' 23:59:59';

    //     break;
      
    //   case 2:
    //     $model->date_1 = request()->get('date_2').' 00:00:00';
    //     $model->date_2 = request()->get('date_2').' 23:59:59';
    //     break;

    //   case 3:
    //     $model->date_1 = request()->get('date_2').' 00:00:00';
    //     $model->date_2 = request()->get('date_2').' 23:59:59';
    //     break;
    // }

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

    // Add category to ticket
    if(!empty(request()->get('TicketToCategory'))) {
      Service::loadModel('TicketToCategory')->__saveRelatedData($model,request()->get('TicketToCategory'));
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

  public function close() {

    if(empty(request()->ticketId)) {
      return Redirect::to('/');
    }

    $model = Service::loadModel('Ticket')->where([
      ['id','=',request()->ticketId],
      ['created_by','=',Auth::user()->id],
      ['closing_option','=',0]
    ]);

    if(empty($model)) {
      Snackbar::message('ไม่สามารถปิดประกาศนี้ได้');
      return Redirect::to('/ticket');
    }

    $model->update([
      'closing_option' => request()->closing_option,
      'closing_reason' => request()->closing_reason
    ]);

    Snackbar::message('ปิดประกาศแล้ว');
    return Redirect::to('/account/ticket');
    
  }
}
