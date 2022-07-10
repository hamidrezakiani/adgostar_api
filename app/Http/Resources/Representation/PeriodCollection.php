<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PeriodCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->transform(function ($period){
          return new PeriodResource($period);
        });
    }
}
