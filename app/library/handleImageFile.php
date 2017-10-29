<?php

namespace App\library;

class HandleImageFile
{
  private $image;
  private $filename;
  private $width;
  private $height;
  private $maxFileSizes = 5242880;
  private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

  public function __construct($image = null) {

    if(!empty($image)) {

      $this->image = $image;
      $this->generateFileName();

      list($this->width,$this->height) = getimagesize($this->image->getRealPath());
    }

  }

  private function generateFileName() {
    $ext = $this->image->getClientOriginalExtension();

    if(empty($ext)) {
      $ext = 'jpg';
    }

    $this->filename = time().Token::generateNumber(15).$this->image->getSize().'.'.$ext;
  }

  public function getFileName() {
    return $this->filename;
  }

  public function getOriginalFileName() {
    return $this->image->getClientOriginalName();
  }

  public function getRealPath() {
    return $this->image->getRealPath();
  }

  public function checkFileType() {
    return in_array($this->image->getMimeType(), $this->acceptedFileTypes);
  }

  public function checkFileSize() {
    if($this->image->getSize() <= $this->maxFileSizes){
      return true;
    }
    return false;
  }

  public function generateImageSize($imageType,$width = null,$height = null){

    $accepteType = array('photo','avatar');

    if(empty($width)) {
      $width = $this->width; 
    }

    if(empty($height)) {
      $height = $this->height; 
    }

    if(!in_array($imageType, $accepteType)) {
      return array($width,$height);
    }

    // $ratio = abs($originalWidth/$originalHeight);

    // $width = $originalWidth;
    // $height = $originalHeight;

    // if($imageType == 'photo') {

    //   if(($originalWidth > 960) || ($originalHeight > 960)) {

    //     if($originalWidth > $originalHeight) {

    //       $width = 960;

    //       if(($ratio > 1) && ($ratio < 1.6)) {
    //         $width = $originalWidth / 2;
    //       } 

    //       $height = $originalHeight * ($width / $originalWidth);

    //     }elseif($originalWidth < $originalHeight) {

    //       $height = 960;

    //       if(($ratio > 1) && ($ratio < 1.6)) {
    //         $height = $originalHeight / 2;
    //       } 

    //       $width = $originalWidth * ($height / $originalHeight);

    //     }else {
    //       // ratio = 1
    //       $width = 960;
    //       $height = 960;
    //     }  

    //   }

    // }elseif($imageType == 'avatar') {
      
    //   if($height > 400) {
    //     // or automatic crop
    //     // top_x (imageWidth - cropsizewidth) / 2
    //     // top_y (imageHeight - cropsizeheight) / 2
    //     // bottom_x = top_x + 400;
    //     // bottom_y = top_y + 400

    //     $height = 400;
    //     $width = $originalWidth * ($height / $originalHeight);
    //   }
    // }

    switch ($imageType) {
      case 'photo':
        $maxSize = 960;
        break;

      case 'avatar':
        $maxSize = 400;
        break;

      default:
        return false;
        break;

    }

    if (($width > $height) && ($width > $maxSize)) {
      $height *= $maxSize / $width;
      $width = $maxSize;
    }else if(($height > $width) && ($height > $maxSize)) {
      $width *= $maxSize / $height;
      $height = $maxSize;
    }else if($width > $maxSize){
      $width = $maxSize;
      $height = $width;
    }

    return array($width,$height);

  }

}