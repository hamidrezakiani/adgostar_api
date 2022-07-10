<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id'          => $this->id,
          'name'        => $this->label,
          'placeholder' => $this->placeholder,
          'help'        => $this->tooltip,
          'minSize'     => $this->minSize,
          'maxSize'     => $this->maxSize,
          'sizeUnit'    => $this->type->sizeUnit,
          'type'        => $this->type->type,
          'dataType'    => $this->type->dataType,
          'required'    => $this->required,
        ];
    }
}
