<?php

namespace App\Http\Resources\Representation\Agent;

use Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;
class SubsetTicketResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        Verta::setStringformat('Y/n/j H:i:s');
        return $this->collection->map(function($ticket){
            if(!$ticket->created_by)
            {
                $ticket->created_by = 'زیرمجموعه';
            }
            elseif($ticket->created_by == auth('representation')->id())
            {
                $ticket->created_by = 'شما';
            }
            else
            {
                $ticket->created_by = 'ادمین';
            }
            $v = new Verta($ticket->created_at);
            $ticket->fullName = $ticket->representation->detail->title;
            $ticket->date = $v->format('H:i  y-n-j');


            return $ticket;
        });
    }
}
