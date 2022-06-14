<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ParticipationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /*$response['participations'] = $this->collection->map(function($participation){

            $participation->countPeriod = $participation->periods->count();
            $participation->productName = $participation->product->name;
            $participation->executerName = $participation->executer
            ->firstName .' '. $participation->executer->lastName;
            if($participation->item_id == NULL)
              $participation->itemName = 'انتخاب نشده';
            else
              $participation->itemName = $participation->item->name;
            return $participation;
         });
         return $response; */
         
         return [
           'id' => $this->id,
           'product_id' => $this->product_id,
           'item_id' => $this->item_id,
           'executerName' => $this->executer->firstName.' '.$this->executer->lastName,
           'productName' => $this->product->name,
           'item_name' => $this->item ? $this->item->name : 'انتخاب نشده',
           'countPeriod' => $this->periods->count(),
           'periods' => new ParticipationPeriodCollection($this->periods),
         ];
    }
}
