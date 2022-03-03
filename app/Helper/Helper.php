<?php

namespace App\Helper;

class Helper { 
  
   public static function log($data)
   {
    $fp = fopen('./log.json'), 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
   }
}
