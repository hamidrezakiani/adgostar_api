<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TreeResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       /* $response['categories'] = $this->collection->map(function($category){
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
            if($category->count_product == 0)
             {
               $category->subCats = new TreeResource($category->subCats);
             }
             else {
               $category->product = new ProductCollection($category->products);
             }
            return $category;
         });
        return $response;*/
        return $this->collection->transform(function($category){
          return [
            'id' => $category->id,
            'parent_id' => $category->parent_id,
            'name' => $category->name,
            'turkish_name' => $category->turkish_name,
            'turkish_label' => $category->turkish_label,
            'count_subCat' => $category->count_subCat,
            'subCats' => new TreeResource($category->subCats),
            'count_product' => $category->count_product,
            'products' => new ProductCollection($category->products),
            'show' => $category->show,
            'tab_index' => $category->tab_index,
          ];
        });
    }

    public function routePage($parent)
    {
        if($parent)
          return array_merge($this->routePage($parent->parent),[['id' => $parent->id,'name'=>$parent->name]]);
        else
          return [];
    }
}
