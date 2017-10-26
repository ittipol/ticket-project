<?php

namespace App\Models;

class TicketToCategory extends Model
{
  protected $table = 'ticket_to_categories';
  protected $fillable = ['ticket_id','ticket_category_id'];
  public $timestamps  = false;

  public function ticket() {
    return $this->hasOne('App\Models\Ticket','id','ticket_id');
  }

  public function ticketCategory() {
    return $this->hasOne('App\Models\TicketCategory','id','ticket_category_id');
  }

  public function __saveRelatedData($model,$value) {

    if(!empty($value['ticket_category_id'])) {

      if($model->state == 'update') {
        $this->where('ticket_id','=',$model->id)->delete();
      }
      
      return $this->fill(array(
        'ticket_id' => $model->id,
        'ticket_category_id' => $value['ticket_category_id']
      ))->save();

    }
    
  }
}
