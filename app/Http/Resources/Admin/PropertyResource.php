<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
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
          'type_id' => $this->type->id,
          'product_id' => $this->product_id,
          'label' => $this->label,
          'turkish_label' => $this->turkish_label,
          'maxSize' => $this->maxSize,
          'minSize' => $this->minSize,
          'sizeUnit' => $this->type->sizeUnit,
          'typeName' => $this->type->name,
          'placeholder' => $this->placeholder,
          'turkish_placeholder' => $this->turkish_placeholder,
          'tooltip' => $this->tooltip,
          'turkish_tooltip' => $this->turkish_tooltip,
          'required' => $this->required,
        ];
    }
}
