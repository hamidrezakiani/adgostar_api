<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\PropertyType;

class ProductResource extends JsonResource
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
          'name' => $this->name,
          'label' => $this->label,
          'turkish_name' => $this->turkish_name,
          'turkish_label' => $this->turkish_label,
          'viewable' => $this->viewable,
          'tab_index' => $this->tab_index,
          'items' => new ItemCollection($this->items),
          'properties' => new PropertyCollection($this->properties),
          'propertyTypes' => PropertyType::all(),
        ];
    }
}
