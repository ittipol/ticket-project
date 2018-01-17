<?php

namespace App\Models;

class TicketToLocation extends Model
{
  protected $table = 'ticket_to_locations';
  protected $fillable = ['ticket_id','location_id'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$options = array()) {

    // if(!empty($options['location_id'])) {

      // check existing
      if($this->where([
        ['ticket_id','=',$model->id],
        ['location_id','=',$options['location_id']]
      ])->exists()) {
        return false;
      }

      $this->where('ticket_id','=',$model->id)->delete();

      if(!empty($options['location_id'])) {
        return $this->fill(array(
          'ticket_id' => $model->id,
          'location_id' => $options['location_id']
        ))->save();
      }

    // }
  }
}
