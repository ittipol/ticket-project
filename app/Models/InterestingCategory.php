<?php

namespace App\Models;

class InterestingCategory extends Model
{
  protected $table = 'interesting_categories';
  protected $fillable = ['user_id','ticket_category_id'];
  public $timestamps  = false;

  public function ticket() {
    return $this->hasOne('App\Models\User','id','user_id');
  }

  public function ticketCategory() {
    return $this->hasOne('App\Models\TicketCategory','id','ticket_category_id');
  }

  public function __saveRelatedData($model,$value) {

    if(!empty($value['ticket_category_id'])) {

      if($model->state == 'update') {
        $this->where('user_id','=',$model->id)->delete();
      }

      foreach ($value['ticket_category_id'] as $categoryId) {
        $this->newInstance()->fill(array(
          'user_id' => $model->id,
          'ticket_category_id' => $categoryId
        ))->save();
      }

    }

    return true;
  }
}
