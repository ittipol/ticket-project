<?php

namespace App\library;

use Session;
// use Schema;

class Snackbar
{
  public static function message($title = '',$type = 'info') {
    Session::flash('message.title', $title);
    Session::flash('message.type', $type); 
  }

}
