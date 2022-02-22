<?php

namespace App\Http\Resources\Representation\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Verta;

class TicketMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $v = new Verta($this->created_at);
         $this->created_at = $v->format('H:i  y-n-j');
         if(!$this->created_by)
                 $this->created_by = 'شما';
             else
                 $this->created_by = 'ادمین';
         return [
            'id' => $this->id,
            'title' => $this->title,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'messages' => new MessageResource($this->messages),
        ];
    }
}
