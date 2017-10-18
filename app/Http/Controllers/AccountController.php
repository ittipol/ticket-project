<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\Paginator;
use App\library\service;
use App\library\Snackbar;
use Auth;
use Redirect;

class AccountController extends Controller
{
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
    return Redirect::to('/');
  }

  public function listView() {

    Service::loadModel('Ticket');

    // if(!empty($conditions)) {
    //   $data = $model->where($conditions)->paginate(24);
    // }else{
    //   $data = $model->paginate(24);
    // }

    //set page
    Paginator::currentPageResolver(function() use ($currentPage) {
        return $currentPage;
    });

    // {{$data->links('shared.pagination', ['paginator' => $data])}}

  }
}
