<?php

namespace App\Models;

use App\library\cache;
use App\library\url;
use App\library\date;
use App\library\currency;
use App\library\format;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $fillable = ['title','description','place_location','price','original_price','date_type','date_1','date_2','contact','created_by'];

  private $dateType = array(
    1 => 'ช่วงวันที่ใช้งานได้',
    2 => 'วันที่แสดง',
    3 => 'วันที่เดินทาง',
  );

  public $imageTypeAllowed = array(
    'photo' => array(
      'limit' => 10
    )
  );

  public function getDateType() {
    return $this->dateType;
  }

  public function getDateTypeById($id) {
    
    if(empty($this->dateType[$id])) {
      return null;
    }

    return $this->dateType[$id];
  }

  public function buildDataList() {

    $cache = new cache;
    $url = new url;
    $date = new date;
    $currency = new currency;
    $format = new format;

    // GET TAGs
    $taggings = $this->getRelatedData('Tagging',
      array(
        'fields' => array('word_id')
      )
    );

    $tags = array();
    foreach ($taggings as $tagging) {
      $tags[] = array_merge($tagging->buildModelData(),array(
        'url' => $url->url('tag').$tagging->word->word
      ));
    }

    // GET Images
    $imageModel = new Image;
    $imageTotal = $imageModel->where([
      'model' => $this->modelName,
      'model_id' => $this->id,
    ])->count();

    $image = null;
    if($imageTotal > 0) {

      $image = $this->getRelatedData('Image',array(
        'first' => true,
        'fields' => array('id','model','model_id','filename','description','image_type_id')
      ));

      $image = array_merge($image->buildModelData(),array(
        '_sm_list_url' => $cache->getCacheImageUrl($image,'sm_list')
      ));

    }

    // $images = array();
    // foreach ($_images as $image) {
    //   $images[] = array_merge($image->buildModelData(),array(
    //     '_sm_list_url' => $cache->getCacheImageUrl($image,'sm_list')
    //   ));
    // }

    $originalPrice = null;
    $save = null;
    if(!empty($this->original_price)) {

      $originalPrice = $currency->format($this->original_price);

      if($this->original_price > $this->price) {
        $save = $format->percent(100 - (($this->price * 100) / $this->original_price)) . '%';
      }

    }

    return array(
      'id' => $this->id,
      'title' => $this->title,
      'description' => $this->description,
      'place_location' => $this->place_location,
      'price' => $currency->format($this->price),
      'original_price' => $originalPrice,
      'save' => $save,
      'date_type' => $this->date_type,
      'dateTypeLabel' => $this->getDateTypeById($this->date_type),
      'date_1' => $date->covertDateToSting($this->date_1),
      'date_2' => $date->covertDateToSting($this->date_2),
      'image' => $image,
      'imageTotal' => $imageTotal,
      'tags' => $tags 
    );
  }

  public function buildDataDetail() {

    $cache = new cache;
    $url = new url;
    $date = new date;
    $currency = new currency;
    $format = new format;

    // GET TAGs
    $taggings = $this->getRelatedData('Tagging',
      array(
        'fields' => array('word_id')
      )
    );

    $tags = array();
    foreach ($taggings as $tagging) {
      $tags[] = array_merge($tagging->buildModelData(),array(
        'url' => $url->url('tag').$tagging->word->word
      ));
    }

    // GET Images
    $imageModel = new Image;
    $imageTotal = $imageModel->where([
      'model' => $this->modelName,
      'model_id' => $this->id,
    ])->count();

    $images = null;
    if($imageTotal > 0) {

      $_images = $this->getRelatedData('Image',array(
        'fields' => array('id','model','model_id','filename','description','image_type_id')
      ));

      foreach ($_images as $image) {
        $images[] = array_merge($image->buildModelData(),array(
          '_preview_url' => $cache->getCacheImageUrl($image,'md_scale')
        ));
      }

    }

    $originalPrice = null;
    $save = null;
    if(!empty($this->original_price)) {

      $originalPrice = $currency->format($this->original_price);

      if($this->original_price > $this->price) {
        $save = $format->percent(100 - (($this->price * 100) / $this->original_price)) . '%';
      }

    }

    return array(
      'title' => $this->title,
      'description' => $this->description,
      'place_location' => $this->place_location,
      'price' => $currency->format($this->price),
      'original_price' => $originalPrice,
      'save' => $save,
      'date_type' => $this->date_type,
      'dateTypeLabel' => $this->getDateTypeById($this->date_type),
      'date_1' => $date->covertDateToSting($this->date_1),
      'date_2' => $date->covertDateToSting($this->date_2),
      'contact' => $this->contact,
      'created_by' => $this->created_by,
      'images' => $images,
      'imageTotal' => $imageTotal,
      'tags' => $tags
    );

  }

}
