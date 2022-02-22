<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['categories'] = $this->collection;
        if($this->collection->count() > 0)
        {
            $response['parent'] = $this->collection[0]->showParent;
        }
        else
        {
            $response['parent'] = NULL;
        }
        return $response;
    }
}
