<?php

namespace App\Http\Resources\Admin;

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
            if($product->periodType == 'SINGLE')
              $product->periodTypeName = 'تکی';
            else
              $product->periodTypeName = 'بازه ای';
            $product->categoryName = $product->category->name;
            return $product;
         });
         return $response;
    }
}
