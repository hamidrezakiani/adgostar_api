<?php

namespace App\Http\Resources\Representation\User;

use Carbon\Carbon;
use Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // $v->formatWord('d F Y')
        Verta::setStringformat('Y/n/j H:i:s');
        // return $v->format('%B %d، %Y'); // دی 07، 1395
        return $this->collection->map(function($ticket){
            if(!$ticket->created_by)
                $ticket->created_by = 'شما';
            else
                $ticket->created_by = 'ادمین';
                $v = new Verta($ticket->created_at);
            $ticket->date = $v->format('H:i  y-n-j');


            return $ticket;
        });
    }
}
