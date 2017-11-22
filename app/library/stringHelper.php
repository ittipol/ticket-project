<?php

namespace App\library;

class StringHelper
{
  public static function strLen($string, $encoding = 'UTF-8') {
    // return strlen(StringHelper::utf8ToTis620($str));
    // return strlen(utf8_decode($string));
    return mb_strlen($string, $encoding);
  }

  public static function truncString($string, $len, $stripTag = true, $cleanText = false){

    if(($len <= 0) || empty($string)) {
      return '';
    }
// dd(mb_internal_encoding()); check encoding
    $string = iconv(mb_detect_encoding($string, mb_detect_order(), true), 'UTF-8', $string);
    mb_internal_encoding('UTF-8');

    // if(empty($string)) {
    //   return '';
    // }

    if($stripTag){
      $string = strip_tags($string);
    }

    if($cleanText) {
      $string = preg_replace('/\s+/', ' ', $string);
    }

    if(mb_strlen($string) <= $len) {
      return $string;
    }

    $_string = $string;

    $string = mb_substr($string, 0, $len);
    $lastChar = mb_substr($string, $len-1, 1); // Check last Char after sub staring

    if(ord($lastChar) !== 32) {
      $pos = mb_strpos($_string,' ',$len);
      if(!empty($pos)) {
        $string = mb_substr($_string, 0, $pos);
      }
    }

    return trim($string).'...';
  }

  public static function generateModelNameCamelCase($modelName) {

    $parts = explode('_', $modelName);

    $modelName = array();
    foreach ($parts as $part) {
      $modelName[] = ucfirst($part);
    };

    return implode('', $modelName);
  }

  public static function generateUnderscoreName($modelName) {

    $alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $len = strlen($modelName);

    $parts = array();
    $loop = true;
    $index = 0;
    $len = strlen($modelName);
    $modelName = lcfirst($modelName);

    while($loop) {

      if(strpos($alpha, $modelName[$index]) > -1) {
        $parts[] = substr($modelName, 0, $index);
        $modelName = lcfirst(substr($modelName, $index));
        $len = strlen($modelName);
        $index = 0;
      }

      $index++;

      if(($index+1) > $len) {
        $parts[] = $modelName;
        $loop = false;
      }

    }

    return implode('_', $parts);
  }

  // public static function utf8ToTis620($string) {

  //   $_string = '';
  //   for ($i = 0; $i < strlen($string); $i++) {
  //     if (ord($string[$i]) === 224) {
  //       $unicode = ord($string[$i + 2]) & 0x3F;
  //       $unicode |= (ord($string[$i + 1]) & 0x3F) << 6;
  //       $unicode |= (ord($string[$i]) & 0x0F) << 12;
  //       $_string .= chr($unicode - 0x0E00 + 0xA0);
  //       $i += 2;
  //     } else {
  //       $_string .= $string[$i];
  //     }
  //   }
  //   return $_string;
  // }

  // public static function substrUtf8($str, $start_p, $len_p, $stripTag = true, $cleanText = false) {
  //     $str_post = "";
  //     if (strlen(utf8ToTis620($str)) > $len_p) {
  //         $str_post = "...";
  //     }
  //     return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start_p . '}' .
  //                     '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len_p . '}).*#s', '$1', $str) . $str_post;
  // }
  
}