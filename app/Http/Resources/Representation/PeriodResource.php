<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
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
          'id'         => $this->id,
          'start'      => $this->itemPeriod->start,
          'end'        => $this->itemPeriod->end > 1000000000 ? null : $this->itemPeriod->end,
          'startLabel' => $this->periodFormat($this->itemPeriod->start),
          'endLabel'   => $this->itemPeriod->end > 1000000000 ? null : $this->periodFormat($this->itemPeriod->end),
          'cost'       => $this->cost,
          'time'       => $this->itemPeriod->time,
        ];
    }
    
    public function periodFormat($count)
    {
        if ($count > 999999 && $count != NULL) {
            $count = round($count / 1000000, 1) . "M";
        } elseif ($count > 999 && $count != NULL) {
            $count = round($count / 1000, 1) . "K";
        }
        return $count;
    }
}
