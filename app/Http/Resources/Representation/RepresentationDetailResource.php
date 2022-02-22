<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentationDetailResource extends JsonResource
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
            'title' => $this->title,
            'background' => url($this->backgroundLogin),
            'logo' => url($this->logo)
        ];
    }
}
