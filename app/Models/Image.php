<?php

namespace App\Models;

use App\library\service;
use App\library\handleImageFile;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['model','model_id','path','filename','description','image_type_id','created_by'];

  // private $maxFileSizes = 5242880;
  // private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

  // public function getMaxFileSizes() {
  //   return $this->maxFileSizes;
  // }

  // public function getAcceptedFileTypes() {
  //   return $this->acceptedFileTypes;
  // }
}
