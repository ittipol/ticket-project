<?php

namespace App\Models;

class Tagging extends Model
{
  public $table = 'taggings';
  protected $fillable = ['model','model_id','word_id'];

  // public function __construct() {  
  //   parent::__construct();
  // }

  public function word() {
    return $this->hasOne('App\Models\Word','id','word_id');
  }

  public function __saveRelatedData($model,$value) {

    $word = new Word;
    $wordIds = $word->saveSpecial($value);

    if(!empty($wordIds)) {

      if($model->state == 'update') {
        $this->where(array(
          array('model','like',$model->modelName),
          array('model_id','=',$model->id),
        ))->delete();
      }
      
      foreach ($wordIds as $wordId) {

        $this->newInstance()->fill(array(
          'model' => $model->modelName,
          'model_id' => $model->id,
          'word_id' => $wordId
        ))->save();

      }

    }

    return true;
  }

  public function buildModelData() {
    if(empty($this->word)) {
      return null;
    }

    return array(
      'word_id' => $this->word->id,
      'word' => $this->word->word
    );
  }

  public function buildFormData() {
  
    return $this->word->word;
  }

  public function setUpdatedAt($value) {}

}
