<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\handleImageFile;
use App\library\imageTool;
use Illuminate\Http\Request;
use Input;

class ImageController extends Controller
{
  public function __construct() {
    $this->botDisallowed();
  }

  public function upload() {

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      return false;
    }

    if(empty(Input::file('image')) || (Input::file('image')->getClientSize() == 0)) {
      return response()->json(array(
        'uploaded' => false
      ));
    }

    $image = new HandleImageFile(Input::file('image'));

    if(!$image->checkFileType() || !$image->checkFileSize()) {
      return response()->json(array(
        'uploaded' => false
      ));
    }

    $tempFile = Service::loadModel('TemporaryFile');

    if(!$tempFile->checkExistSpecifiedTemporaryRecord(Input::get('model'),Input::get('imageToken'))) {
      $tempFile->fill(array(
        'model' => Input::get('model'),
        'token' => Input::get('token')
      ))->save();
    }
    
    // list($width,$height) = $image->generateImageSize(Input::get('imageType'));

    $temporaryPath = $tempFile->createTemporyFolder(Input::get('model').'_'.Input::get('token').'_'.Input::get('imageType'));

    $imageTool = new ImageTool($image->getRealPath());
    // $imageTool->png2jpg($width,$height);
    // $imageTool->resize($width,$height);
    $moved = $imageTool->save($temporaryPath.$image->getFileName());

    if(!$moved) {
      return response()->json(array(
        'uploaded' => false
      ));
    }

    return response()->json(array(
      'uploaded' => true,
      'filename' => $image->getFileName()
    ));
  }
}
