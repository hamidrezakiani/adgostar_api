<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubsetSearchResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $representations = $this->collection->map(function($representation){
            $representation->name = $representation->detail->title;
            return $representation;
         });
         $searchData =  array_column($representations->toArray(), 'id','name');
         return $searchData;
    }
}
