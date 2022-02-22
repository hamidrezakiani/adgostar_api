<?php

namespace App\Http\Resources\Representation\Agent;

use App\Http\Resources\Representation\Agent\SubsetMessageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Verta;
class SubsetTicketMessageResource extends JsonResource
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
            'fullName' =>  $this->representation->detail->title,
            'logo' => url($this->representation->detail->logo),
            'messages' => new SubsetMessageResource($this->messages),
        ];
    }
}
