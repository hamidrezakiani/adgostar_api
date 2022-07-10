<?php

namespace App\Http\Resources\Representation;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /*$response['services'] = $this->collection->map(function($product){
           $product->items = $product->items->map(function($item){
             $item->periods = $item->periods->map(function($period){
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
             $item->maxOrderLabel = ($item->maxOrder < 1000000000000) ? $this->periodFormat($item->maxOrder) : 'بی نهایت';
             return $item;
           });
           return $product;
        });
        return $response;*/
        
        return [
          'id'    => $this->id,
          'label' => $this->label,
          'items' => new ItemCollection($this->items),
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
