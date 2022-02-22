<?php

namespace App\Services;
use Hekmatinasser\Verta\Verta;

class TimeService
{
   public function changeHour($timestamp,$newHour)
   {
        $v = new Verta();
        $v->timestamp($timestamp);
        $date = new Verta();
        $date->year($v->year);
        $date->month($v->month);
        $date->day($v->day);
        $date->hour($newHour);
        $date->minute(0);
        $date->second(0);
        return $date->timestamp;
   }

   public function sumTime($time,$hours)
   {
      $time = $time + $hours*3600;
      return $time;
   }
}
