<?php

namespace App\Models;

use App\library\stringHelper;
use Auth;

class HashtagLog extends Model
{
  protected $table = 'hashtag_logs';
  protected $fillable = ['model','model_id','hashtag_id','catagory_id','created_by'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$value) {

    $now = date('Y-m-d H:i:s');

    foreach (StringHelper::getHashtagFromString($value) as $match) {

      $hashtag = Hashtag::where('hashtag','=',$match[0]);

      if($hashtag->exists()) {
        $hashtag = $hashtag->first();

        // check hashtag log
        $_hashtagLog = $this->where([
          ['model','=',$model->modelName],
          ['model_id','=',$model->id],
          ['hashtag_id','=',$hashtag->id],
          ['created_by','=',Auth::user()->id]
        ]);

        if(!$_hashtagLog->exists()) {

          // update last input
          $hashtag->update(
            ['last_input' => $now]
          );

          // Save new hashtag log
          $this->_save(array(
            'model' => $model->modelName,
            'modelId' => $model->id,
            'hashtagId' => $hashtag->id,
            'userId' => Auth::user()->id
          ));
        }
      }else {
        // save new hashtag
        $hashtag = new Hashtag;
        $hashtag->hashtag = $match[0];
        $hashtag->last_input = $now;
        $hashtag->save();

        $this->_save(array(
          'model' => $model->modelName,
          'modelId' => $model->id,
          'hashtagId' => $hashtag->id,
          'userId' => Auth::user()->id
        ));
      }

    }

    return true;
  }

  public function _save($value) {
    $_hashtagLog = $this->newInstance();
    $_hashtagLog->model = $value['model'];
    $_hashtagLog->model_id = $value['modelId'];
    $_hashtagLog->hashtag_id = $value['hashtagId'];
    $_hashtagLog->created_by = $value['userId'];
    return $_hashtagLog->save();
  }

}
