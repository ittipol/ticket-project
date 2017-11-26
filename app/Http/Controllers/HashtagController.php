<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\library\service;
use App\library\snackbar;
use Redirect;

class HashtagController extends Controller
{
  public function index(Request $request, $hashTag) {

    $model = Service::loadModel('Ticket')->query();

    $currentPage = 1;
    if($request->has('page')) {
      $currentPage = $request->page;
    }
    //set page
    Paginator::currentPageResolver(function() use ($currentPage) {
        return $currentPage;
    });


    $hashtag = trim(strip_tags($hashTag));

    if(empty($hashtag)) {
      Snackbar::message('Hashtag ไม่ถูกต้อง');
      return Redirect::to('/');
    }

    // if(substr($_q, 0, 1) !== '#') {$hashTag = '#'.trim($hashTag);}

    $hashTag = '#'.trim($hashTag);
    $now = date('Y-m-d H:i:s');

    $model->where(function($query) use ($now) {

      $query
      ->where(function($query) use ($now) {
        $query
        ->where('tickets.date_1','=',null)
        ->orWhere('tickets.date_1','>=',$now);
      })
      ->orWhere(function($query) use ($now) {
        $query
        ->where('tickets.date_2','!=',null)
        ->where('tickets.date_2','>=',$now);
      });

    });

    $model->where(function($q) use($hashTag) {
      $q->where([
        ['description','like','%'.$hashTag.'%'],
        ['closing_option','=',0]
      ]);
    });

    $model->orderBy('tickets.activated_date','desc');

    $this->setData('data',$model->paginate(48));
    $this->setData('hashtag',$hashTag);

    return $this->view('pages.hashtag.list');

  }
}
