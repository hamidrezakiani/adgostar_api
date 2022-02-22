<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipationPeriodResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['periods'] = $this->collection->map(function($period){
            if($period->end >= 1000000000000)
              $period->end = 'بی نهایت';
            return $period;
         });
         return $response;
    }
}
