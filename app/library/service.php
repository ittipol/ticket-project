<?php

namespace App\library;

use Facebook\Facebook;
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

  public static function facebookGetUserProfile($accessToken) {

    $fb = new Facebook([
      'app_id' => env('FB_APP_ID'),
      'app_secret' => env('FB_SECRET_ID'),
      'default_graph_version' => env('GRAPH_VERSION'),
    ]);

    try {
      // Returns a `Facebook\FacebookResponse` object
      return $fb->get('/me?fields=id,name,email', $accessToken);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // $message = 'Graph returned an error: ' . $e->getMessage();
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // $message = 'Facebook SDK returned an error: ' . $e->getMessage();
    }

    return false;
  }

  public static function facebookReScrap($url = null, $absPath = false){

    // js
    // window.fbAsyncInit = function() {
    //   FB.init({
    //     appId      : '{{env("FB_APP_ID")}}',
    //     xfbml      : true,
    //     version    : '{{env("GRAPH_VERSION")}}'
    //   });

    //   FB.api('https://graph.facebook.com/', 'post', {
    //       id: '{url}',
    //       scrape: true,
    //       access_token: '{app-id}|{app-secret}'
    //   }, function(response) {
    //       //console.log('rescrape!',response);
    //       console.log('rescrape!',response);
    //   });
    // };

    if(empty($url)) {
      return false;
    }

    if(!$absPath) {
      $url = Url::url('/').$url;
    }

    $fb = new Facebook([
      'app_id' => env('FB_APP_ID'),
      'app_secret' => env('FB_SECRET_ID'),
      'default_graph_version' => env('GRAPH_VERSION'),
    ]);

    try {
      $response = $fb->post(
        '/',
        array (
          'scrape' => 'true',
          'id' => $url
        ),
        env('FB_APP_ID').'|'.env('FB_SECRET_ID') // App Access Token {app-id}|{app-secret}
      );
    } catch(FacebookExceptionsFacebookResponseException $e) {
      // $message = 'Graph returned an error: ' . $e->getMessage();
      return false;
    } catch(FacebookExceptionsFacebookSDKException $e) {
      // $message = 'Facebook SDK returned an error: ' . $e->getMessage();
      return false;
    }
    // $graphNode = $response->getGraphNode();

    return true;

    // $ch = curl_init("https://developers.facebook.com/tools/debug/og/object/?q=".$url);
    // curl_setopt($ch, CURLOPT_HEADER, 0);
    // curl_exec($ch);
    // curl_close($ch);
  }

  // private static function sendPost($url, $post) {
  //   $r = curl_init();
  //   curl_setopt($r, CURLOPT_URL, $url);
  //   curl_setopt($r, CURLOPT_POST, 1);
  //   curl_setopt($r, CURLOPT_POSTFIELDS, $post);
  //   curl_setopt($r, CURLOPT_RETURNTRANSFER, 1);
  //   curl_setopt($r, CURLOPT_CONNECTTIMEOUT, 5);
  //   $data = curl_exec($r);
  //   curl_close($r);
  //   return $data;
  // }

}
