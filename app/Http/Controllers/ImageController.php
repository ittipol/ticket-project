<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
  public function upload() {

    $res = array(
      'done' => true
    );

    return response()->json($res);
  }
}
