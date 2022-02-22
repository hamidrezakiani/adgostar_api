<?php

namespace App\Http\Resources\Representation;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'isAgent' => $this->representation ? 'http://'.$this->representation->domain.'/admin' : false,
            'isUser' => $this->user ? 'http://'.$this->user->representation->domain.'/user' : false,
            'isExecuter' => $this->executer ? env('EXECUTER_DOMAIN') : false,
            'created_at' => $this->created_at,
        ];
    }
}
