<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\library\service;
use App\library\Snackbar;
use Auth;
use Redirect;

class AccountController extends Controller
{
  public function profile() {

    $data = Service::loadModel('Ticket')
    ->orderBy('created_at','desc')
    ->take(3)
    ->get();

    $list = array();
    foreach ($data as $value) {
      $list[] = $value->buildDataList();
    }

    $this->setData('list',$list);

    return $this->view('pages.account.profile');
  }
  public function edit() {
    $user = Service::loadModel('User')->find(Auth::user()->id);

    $this->setData('data',$user);
    $this->setData('profileImage',json_encode($user->getProfileImage()));

    $this->setMeta('title','แก้ไขโปรไฟล์');

    return $this->view('pages.account.form.profile_edit');
  }

  public function profileEditingSubmit() {
    $user = Service::loadModel('User')->find(Auth::user()->id);

    $user->name = request()->get('name');

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
        'first' => true
      ));

      // remove old avatar

      $user->avatar = $image->id;
      $user->save();

    }

    Snackbar::message('โปรไฟล์ถูกบันทึกแล้ว');
    return Redirect::to('/account');
  }

  public function listView() {

    $model = Service::loadModel('Ticket');

    $currentPage = 1;
    if(!empty(request()->page)) {
      $currentPage = request()->page;
    }
    //set page
    Paginator::currentPageResolver(function() use ($currentPage) {
        return $currentPage;
    });

    // Search Query String
    $conditions = array();

    if(!empty(request()->q)) {
      $conditions[] = array('name','=','%'.request()->q.'%');
    }

    if(!empty($conditions)) {
      $data = $model->where($conditions)->paginate(24);
    }else{
      $data = $model->paginate(24);
    }

    $this->setData('data',$data);

    // {{$data->links('shared.pagination', ['paginator' => $data])}}

    // SET META
    // $this->setMeta('title','');
    // $this->setMeta('description','');
    // $this->setMeta('image',null);

    return $this->view('page.account.list');

  }
}
