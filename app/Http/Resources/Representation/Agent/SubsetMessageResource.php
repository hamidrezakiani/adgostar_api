<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Verta;
class SubsetMessageResource extends ResourceCollection
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
        return $this->collection->map(function($message){
             $v = new Verta($message->created_at);
             $message->date = $v->format('H:i  y-n-j');
             if($message->representation_id == auth('representation')->id())
             {
                $message->created_by = 'YOU';
             }
             else
             {
                 $message->created_by = 'ADMIN';
             }
             return $message;
         });
    }
}
