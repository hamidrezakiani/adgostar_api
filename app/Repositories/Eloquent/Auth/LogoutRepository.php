<?php

namespace App\Repositories\Eloquent\Auth;

use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Interfaces\Auth\LogoutRepositoryInterface;

class LogoutRepository extends AccountRepository implements LogoutRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function removeToken($request) : Bool
    {
        $userId = $this->model->where('api_token',$request->bearerToken())->first()->id;
        return $this->update(['api_token' => NULL],$userId);
    }
}
