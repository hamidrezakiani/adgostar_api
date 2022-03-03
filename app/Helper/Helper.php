<?php

namespace App\Helper;

class Helper { 
  
   public function log($data)
   {
    $fp = fopen(url('log.json'), 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
   };
};
