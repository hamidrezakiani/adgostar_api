<?php

namespace App\Http\Resources\Representation\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'fullName' => $this->firstName." ".$this->lastName,
            'avatar' => url($this->avatar),
            'phone' => $this->phone,
            'verify' => $this->verify,
            'isAdmin' => $this->admin ? env('ADMIN_DOMAIN') : false,
            'isAgent' => $this->agent ? 'http://'.$this->representation->domain.'/admin' : false,
            'isExecuter' => $this->executer ? env('EXECUTER_DOMAIN') : false,
            'created_at' => $this->created_at,
        ];
    }
}
