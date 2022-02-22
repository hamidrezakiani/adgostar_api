<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['products'] = $this->collection->map(function($product){
           $product->items = $product->items()->readyService()->get();
           $product->categoryName = $product->category->label;
           return $product;
        });
        return $response;
    }
}
