<?php

namespace App\Http\Resources\Representation\Agent;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserSearchResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = $this->collection->map(function($user){
           $user->name = $user->account->firstName." "
           .$user->account->lastName." ".$user->account->phone;
           return $user;
        });
        $searchData =  array_column($users->toArray(), 'id','name');
        return $searchData;
    }
}
