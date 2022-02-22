<?php

namespace App\Http\Resources\Executer;

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
                $product->participation = $product->executerParticipation(auth('executer')->id());
              $product->categoryName = $product->category->name;
            return $product;
         });
         return $response;
    }
}
