<?php

namespace App\Http\Resources\Representation\User;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Verta;
class OrderPropertiesResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($orderProperties){
             $orderProperties->dataType = $orderProperties->property->type->dataType;
             $orderProperties->type = $orderProperties->property->type->type;
             $orderProperties->name = $orderProperties->property->label;
             return $orderProperties;
         });
    }
}
