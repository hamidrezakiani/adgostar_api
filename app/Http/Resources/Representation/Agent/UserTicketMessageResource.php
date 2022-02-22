<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\JsonResource;
use Verta;

class UserTicketMessageResource extends JsonResource
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
         {

            $this->created_by = 'کاربر';
         }
         elseif($this->created_by == auth('representation')->id())
         {
            $this->created_by = 'شما';
         }
        else
        {
            $this->created_by = 'ادمین';
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'fullName' =>  $this->user->account->firstName." ".$this->user->account->lastName,
            'avatar' => url($this->user->account->avatar),
            'messages' => new UserMessageResource($this->messages),
        ];
    }
}
