<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileEditRequest;
use Illuminate\Pagination\Paginator;
use App\library\service;
use App\library\snackbar;
use Auth;
use Redirect;

class AccountController extends Controller
{
  public function __construct() {
    $this->botDisallowed();
  }

  public function profile() {

    $data = Service::loadModel('Ticket')
    ->where([
      ['closing_option','=',0],
      ['created_by','=',Auth::user()->id]
    ])
    ->orderBy('created_at','desc')
    ->take(4)
    ->get();

    $this->setData('data',$data);
    $this->setMeta('title','โปรไฟล์ — TicketEasys');

    return $this->view('pages.account.profile');
  }
  public function edit() {
    $user = Service::loadModel('User')->find(Auth::user()->id);

    $this->setData('data',$user);
    $this->setData('profileImage',json_encode($user->getProfileImage()));

    $this->setMeta('title','แก้ไขโปรไฟล์ — TicketEasys');

    return $this->view('pages.account.form.profile_edit');
  }

  public function profileEditingSubmit(ProfileEditRequest $request) {
    $user = Service::loadModel('User')->find(Auth::user()->id);

    $user->name = $request->name;

    if(!$user->save()) {
      Snackbar::message('ไม่สามารถบันทึกได้');
      return Redirect::back();
    }

    // images
    if(!empty(request()->get('Image'))) {

      $imageModel = Service::loadModel('Image');
      $imageModel->__saveRelatedData($user,request()->get('Image'));

      $image = $user->getRelatedData('Image',array(
        'fields' => array('id'),
        'first' => true,
        'order' => array('id','desc')
      ));

      // remove old avatar

      $user->avatar = $image->id;
      $user->save();

    }

    Snackbar::message('โปรไฟล์ถูกบันทึกแล้ว');
    return Redirect::to('/account');
  }

  public function ticket() {

    $model = Service::loadModel('Ticket');

    $currentPage = 1;
    if(request()->has('page')) {
      $currentPage = request()->page;
    }
    //set page
    Paginator::currentPageResolver(function() use ($currentPage) {
        return $currentPage;
    });

    $data = $model->where([
              ['closing_option','=',0],
              ['created_by','=',Auth::user()->id]
            ])
            ->orderBy('created_at','asc')
            ->paginate(36);

    $this->setData('data',$data);

    // SET META
    $this->setMeta('title','รายการขายของฉัน — TicketEasys');
    
    return $this->view('pages.account.ticket_list');

  }

}
