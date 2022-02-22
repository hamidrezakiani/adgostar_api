<?php

namespace App\Http\Resources\Executer;

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
        $response['categories'] = $this->collection->map(function($category){
            $category->count_subCat = $category->showSubCats()->readyParticipation()->count();
            $category->count_product = $category->products()->viewable()->count();
            return $category;
         });
        return $response;
    }

    public function routePage($parent)
    {
        if($parent)
          return array_merge($this->routePage($parent->parent),[['id' => $parent->id,'name'=>$parent->name]]);
        else
          return [];
    }
}
