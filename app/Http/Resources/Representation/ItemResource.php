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
        $this->periods = $this->periods->map(function($period){
            $temp['startLabel'] = $period->itemPeriod->start;
            $temp['endLabel'] = $period->itemPeriod->end;
            $temp['startLabel'] = $this->periodFormat($period->itemPeriod->start);
            $temp['endLabel'] = ($period->itemPeriod->end < 1000000000000) ? $this->periodFormat($period->itemPeriod->end) : 'بی نهایت';
            $temp['start'] = $period->itemPeriod->start;
            $temp['end'] = $period->itemPeriod->end;
            $temp['cost'] = $period->cost;
            $temp['time'] = $period->itemPeriod->time;
            return $temp;
        });
        $this->maxOrderLabel = ($this->maxOrder < 1000000000000) ? $this->periodFormat($this->maxOrder) : 'بی نهایت';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'product' => $this->product,
            'properties' => $this->product->properties()->with('type')->get(),
            'maxOrder' => $this->maxOrder,
            'maxOrderLabel' => $this->maxOrderLabel,
            'periods' => $this->periods
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
