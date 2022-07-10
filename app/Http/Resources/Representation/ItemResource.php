<?php

namespace App\Http\Resources\Representation;

use Illuminate\Database\Eloquent\Collection;
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
          'id'            => $this->id,
          'product_id'    => $this->product_id,
          'label'         => $this->label,
          'product_label' => $this->product->label,
          'properties'    => new PropertyCollection($this->product->properties()->with('type')->get()),
          'maxOrder'      => $this->maxOrder > 1000000000 ? null : $this->maxOrder,
          'maxOrderLabel' => $this->maxOrder > 1000000000 ? null : (new PeriodResource($this->periods[0]))->periodFormat($this->maxOrder),
          'periods'       => new PeriodCollection($this->periods),
        ];
    }

}
