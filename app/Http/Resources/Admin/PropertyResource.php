<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['properties'] = $this->collection->map(function ($property) {
            $property->productName = $property->product->name;
            $property->typeName = $property->type->name;
            return $property;
        });
        return $response;
    }
}
