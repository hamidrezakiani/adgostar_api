<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ParticipationResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response['participations'] = $this->collection->map(function($participation){

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
         return $response;
    }
}
