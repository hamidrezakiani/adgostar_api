<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\JsonResource;
use Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserTicketResource extends ResourceCollection
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
                $ticket->created_by = 'کاربر';
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
            $ticket->fullName = $ticket->user->account->firstName." ".$ticket->user->account->lastName;
            unset($ticket['user']);
            $ticket->date = $v->format('H:i  y-n-j');


            return $ticket;
        });
    }
}
