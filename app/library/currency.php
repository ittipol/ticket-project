<?php

namespace App\library;

class Currency {

	public function format($number) {

    if(!Validation::isCurrency($number)) {
      return null;
    }

    $pos = strpos($number, '.');

    if(empty($pos)) {
      return 'THB '.number_format($number, 0, '.', ',');
    }

    list($integer,$point) = explode('.', $number);

    if((int)$point == 0) {
      return 'THB '.number_format($number, 0, '.', ',');
    }

    return 'THB '.$number;

	}

}
