<?php

namespace App\Http\Resources\Admin;

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
            if(!$category->parent)
            {
                $category->parentName = 'اصلی';
                $category->parent_id = 0;
            }
            else
            {
               $category->parentName = $category->parent->name;
            }
            if(!$category->showParent)
            {
                $category->showParentName = 'اصلی';
                $category->showParent_id = 0;
            }
            else
            {
               $category->showParentName = $category->showParent->name;
            }
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
