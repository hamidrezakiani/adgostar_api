<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ItemPeriodResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['periods'] = $this->collection->map(function($period){
           $period->start = $this->periodFormat($period->itemPeriod->start);
           if($period->itemPeriod->end < 1000000000000)
             $period->end = $this->periodFormat($period->itemPeriod->end);
           else
             $period->end = 'بی نهایت';
           $period->userCost = ceil($period->baseCost * (1 + $period->userProfit / 100));
           $period->seniorRepresentationCost = ceil($period->baseCost * (1 + $period->seniorRepresentationProfit / 100));
           $period->normalRepresentationCost = ceil($period->baseCost * (1 + $period->normalRepresentationProfit / 100));
           $period->baseCost = ceil($period->baseCost);
           $period->userProfit = ($period->userCost / $period->baseCost - 1) * 100;
           $period->normalRepresentationProfit = ($period->normalRepresentationCost / $period->baseCost - 1) * 100;
           $period->seniorRepresentationProfit = ($period->seniorRepresentationCost / $period->baseCost - 1) * 100;
           unset($period->itemPeriod);
           unset($period->deleted_at);
           unset($period->updated_at);
           unset($period->created_at);
           return $period;
        });
        return $response;
    }

    public function periodFormat($count)
    {
        if($count > 999999 && $count != NULL)
        {
           $count = round($count / 1000000,1)."M";
        }
        elseif($count > 999 && $count != NULL)
        {
           $count = round($count / 1000, 1) . "K";
        }
        return $count;
    }
}
