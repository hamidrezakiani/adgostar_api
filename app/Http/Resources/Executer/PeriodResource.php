<?php

namespace App\Http\Resources\Executer;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PeriodResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['periods'] = $this->collection;
         return $response;
    }
}
