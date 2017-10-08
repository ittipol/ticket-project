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
  protected $fillable = ['title','description','place_location','price','original_price','start_date','expiration_date','created_by'];

  public $imageTypeAllowed = array(
    'photo' => array(
      'limit' => 10
    )
  );

  public function buildDataList() {

    $cache = new cache;
    $url = new url;
    $date = new date;
    $currency = new currency;
    $format = new format;

    // dd($this);

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
    $_images = $this->getRelatedData('Image',array(
      'fields' => array('id','model','model_id','filename','description','image_type_id')
    ));

    $images = array();
    foreach ($_images as $image) {
      $images[] = array_merge($image->buildModelData(),array(
        '_sm_list_url' => $cache->getCacheImageUrl($image,'sm_list')
      ));
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
      'start_date' => $date->covertDateToSting($this->start_date),
      'expiration_date' => $date->covertDateToSting($this->expiration_date),
      'images' => $images,
      'tags' => $tags 
    );
  }
}
