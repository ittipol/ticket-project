<?php

namespace App\library;

use App\Models\UserLog;
use Request;
use Auth;

class Service
{
  public static function loadModel($modelName) {
    $class = 'App\Models\\'.$modelName;

    if(!class_exists($class)) {
      return false;
    }

    return new $class;
  }

  public static function getIp() {
    // $ipaddress = null;
    // if (getenv('HTTP_CLIENT_IP'))
    //     $ipaddress = getenv('HTTP_CLIENT_IP');
    // else if(getenv('HTTP_X_FORWARDED_FOR'))
    //     $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    // else if(getenv('HTTP_X_FORWARDED'))
    //     $ipaddress = getenv('HTTP_X_FORWARDED');
    // else if(getenv('HTTP_FORWARDED_FOR'))
    //     $ipaddress = getenv('HTTP_FORWARDED_FOR');
    // else if(getenv('HTTP_FORWARDED'))
    //    $ipaddress = getenv('HTTP_FORWARDED');
    // else if(getenv('REMOTE_ADDR'))
    //     $ipaddress = getenv('REMOTE_ADDR');
    // else
    //     $ipaddress = 'UNKNOWN';
    // return $ipaddress;

    return Request::ip();

  }

  public static function addUserLog($modelName,$modelId,$action,$userId = null) {

    if(empty($userId) && Auth::check()) {
      $userId = Auth::user()->id;
    }elseif(empty($userId)) {
      return false;
    }

    // if(!Auth::check()) {
    //   return false;
    // }

    $userLogModel = new UserLog;
    $userLogModel->model = $modelName;
    $userLogModel->model_id = $modelId;
    $userLogModel->action = $action;
    $userLogModel->ip_address = Service::getIp();
    $userLogModel->user_id = $userId;

    return $userLogModel->save();
  }

  public static function getList($records,$field) {
    $lists = array();
    foreach ($records as $record) {
      $lists[] = $record->{$field};
    }
    return $lists;
  }

  public static function updateFacebookScrap($url = null){
    if(empty($url)) {
      return false;
    }

    $ch = curl_init("http://developers.facebook.com/tools/debug/og/object?q=".Url::url('/').$url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
  }

}
