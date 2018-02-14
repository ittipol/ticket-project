<?php

namespace App\Models;

use App\library\cache;
use App\library\url;
use App\library\date;
use App\library\currency;
use App\library\format;
use App\library\stringHelper;

class Ticket extends Model
{
  protected $table = 'tickets';
  protected $fillable = [
  'title',
  'description',
  'place_location',
  'price',
  'original_price',
  'date_type',
  'date_1',
  'date_2',
  'contact',
  'purpose',
  'closing_option',
  'closing_reason',
  // 'scraped',
  'created_by',
  'activated_date'];

  private $dateType = array(
    1 => 'ช่วงวันที่ใช้งานได้',
    2 => 'วันที่แสดง',
    3 => 'วันที่เดินทาง',
    0 => 'ไม่ระบุ',
  );

  private $rePostDays = 259200; // 3 days // 86400

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

  public function getLocationId() {
    
    $ticketToLocation = $this->getRelatedData('TicketToLocation',array(
      'fields' => array('location_id'),
      'first' => true
    ));

    if(empty($ticketToLocation)) {
      return null;
    }

    return $ticketToLocation->location_id;
  }

  public function getLocationPaths() {

    $ticketToLocation = TicketToLocation::where('ticket_id','=',$this->id)->select('location_id');

    if(!$ticketToLocation->exists()) {
      return null;
    }

    $LocationModel = new Location;

    return $LocationModel->getLocationPaths($ticketToLocation->first()->location_id);
  }

  public function getLocationBreadcrumb() {

    $itemToLocation = TicketToLocation::where('ticket_id','=',$this->id)->select('location_id');

    if(!$itemToLocation->exists()) {
      return null;
    }

    $LocationModel = new Location;

    return $LocationModel->breadcrumb($itemToLocation->first()->location_id);
  }

  public function buildDataList($titleLength = 90,$findDaysLeft = false) {

    $cache = new cache;

    // GET TAGs
    // $taggings = $this->getRelatedData('Tagging',
    //   array(
    //     'fields' => array('word_id')
    //   )
    // );

    // $tags = array();
    // foreach ($taggings as $tagging) {
    //   $tags[] = array_merge($tagging->buildModelData(),array(
    //     'url' => Url::url('tag').$tagging->word->word
    //   ));
    // }

    $imageTotal = Image::where([
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
        '_preview_url' => $cache->getCacheImageUrl($image,'list_pw_scale'),
        'formation' => $image->getFormation()
      ));

    }
    // Price
    $originalPrice = null;
    $save = null;
    if(!empty($this->original_price)) {
      $originalPrice = Currency::format($this->original_price);

      if($this->original_price > $this->price) {
        $save = Format::percent(100 - (($this->price * 100) / $this->original_price)) . '%';
      }
    }

    // Ticket Category
    $category = $this->getRelatedData('TicketToCategory',array(
      'first' => true,
      'fields' => array('ticket_category_id')
    ));

    $_category = null;
    if(!empty($category)) {
      $_category = $category->ticketCategory->name;
    }

    $description = null;
    $descLen = 120 - StringHelper::strLen($this->title);
    if($descLen > 10) {
      $description = StringHelper::truncString($this->description,$descLen,true,true);
    }

    $pullingPost = null;
    
    if($findDaysLeft) {
      $pullingPost = $this->checkRePost();
    }

    // Get Expired date
    switch ($this->date_type) {
      case 1:
          $expireDate = strtotime($this->date_2);
        break;

      case 2:
          $expireDate = strtotime($this->date_1);
        break;

      case 3:
          $expireDate = strtotime($this->date_1);
        break;
      
      default:
          $expireDate = 0;
        break;
    }

    return array(
      'id' => $this->id,
      'title' => $this->title,
      // 'description' => $this->description,
      // 'title' => StringHelper::truncString($this->title,$titleLength,true,true),
      'description' => $description,
      'place_location' => $this->place_location,
      'price' => Currency::format($this->price),
      'original_price' => $originalPrice,
      'save' => $save,
      'closing_option' => $this->closing_option,
      'date_type' => $this->date_type,
      'dateTypeLabel' => $this->getDateTypeById($this->date_type),
      'date_1' => Date::covertDateToSting($this->date_1),
      'date_2' => Date::covertDateToSting($this->date_2),
      'created_by' => $this->created_by,
      'created_at' => Date::calPassedDate($this->created_at->format('Y-m-d H:i:s')),
      'category' => $_category,
      'user' => User::buildProfileForTicketList($this->created_by),
      'image' => $image,
      'expireDate' => $expireDate,
      // 'imageTotal' => $imageTotal,
      // 'tags' => $tags,
      'pullingPost' => $pullingPost
    );
  }

  public function buildDataDetail() {

    // GET TAGs
    // $taggings = $this->getRelatedData('Tagging',
    //   array(
    //     'fields' => array('word_id')
    //   )
    // );

    // $tags = array();
    // foreach ($taggings as $tagging) {
    //   $tags[] = array_merge($tagging->buildModelData(),array(
    //     'url' => Url::url('tag').$tagging->word->word
    //   ));
    // }

    // GET Images
    $imageModel = new Image;
    $imageTotal = $imageModel->where([
      'model' => $this->modelName,
      'model_id' => $this->id,
    ])->count();

    $images = null;
    if($imageTotal > 0) {

      $_images = $this->getRelatedData('Image',array(
        'fields' => array('id','model','model_id','filename','image_type_id')
      ));

      foreach ($_images as $image) {
        $images[] = $image->buildSlide();
      }

    }

    $originalPrice = null;
    $save = null;
    if(!empty($this->original_price)) {
      $originalPrice = Currency::format($this->original_price);

      if($this->original_price > $this->price) {
        $save = Format::percent(100 - (($this->price * 100) / $this->original_price)) . '%';
      }
    }

    $category = $this->getRelatedData('TicketToCategory',array(
      'first' => true,
      'fields' => array('ticket_category_id')
    ));

    $_category = null;
    $_categoryId = null;
    if(!empty($category)) {
      $_category = $category->ticketCategory->name;
      $_categoryId = $category->ticket_category_id;
    }

    foreach (StringHelper::getHashtagFromString($this->description) as $value) {
      // $value = strip_tags($value);
      // substr($value, 1)
      $this->description = str_replace($value, '<a href="/?q='.$value.'">'.$value.'</a>', $this->description);
    }

    foreach (StringHelper::getUrlFromString($this->description) as $value) {
      // if(strpos($value, ',')) {
      //   continue;
      // }
      $this->description = str_replace($value, '<a href="'.$value.'">'.$value.'</a>', $this->description);
    }

    return array(
      'id' => $this->id,
      'title' => $this->title,
      'description' => nl2br($this->description),
      'place_location' => $this->place_location,
      'price' => Currency::format($this->price),
      'original_price' => $originalPrice,
      'save' => $save,
      'closing_option' => $this->closing_option,
      'date_type' => $this->date_type,
      'dateTypeLabel' => $this->getDateTypeById($this->date_type),
      'date_1' => Date::covertDateToSting($this->date_1),
      'date_2' => Date::covertDateToSting($this->date_2),
      'contact' => nl2br($this->contact),
      'created_by' => $this->created_by,
      'created_at' => Date::calPassedDate($this->created_at->format('Y-m-d H:i:s')),
      'category_id' => $_categoryId,
      'category' => $_category,
      'images' => $images,
      'imageTotal' => $imageTotal,
      // 'tags' => $tags,
      // 'seller' => User::buildProfileForTicketDetail($this->created_by),
      'pullingPost' => $this->checkRePost()
    );
  }

  public function getShortDesc() {
    if(empty($this->description)) {
      require null;
    }
    return StringHelper::truncString($this->description,220,true,true);
  }

  public function getRePostDays() {
    return $this->rePostDays;
  }

  public function checkRePost() {
    $pullingPost = false;
    $daysLeft = null;

    $timeDiff = strtotime(date('Y-m-d H:i:s')) - strtotime($this->activated_date);

    if($timeDiff >= $this->rePostDays) {
      // Allow pulling post
      $pullingPost = true;
    }else {
      $daysLeft = Date::findRemainingDays($this->rePostDays - $timeDiff);
    }

    return array(
      'allow' => $pullingPost,
      'daysLeft' => $daysLeft
    );
  }

}
