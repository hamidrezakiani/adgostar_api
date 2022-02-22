<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\JsonResource;

class RepresentationLoginResource extends JsonResource
{
    public static $wrap = 'loginDetail';
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
