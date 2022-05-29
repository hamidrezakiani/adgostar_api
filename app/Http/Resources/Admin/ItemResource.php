<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'product_id' => $this->product_id,
          'name' => $this->name,
          'alias' => $this->alias,
          'turkish_name' => $this->turkish_name,
          'turkish_alias' => $this->turkish_alias,
          'viewable' => $this->viewable,
          'tab_index' => $this->tab_index,
        ];
    }
}
