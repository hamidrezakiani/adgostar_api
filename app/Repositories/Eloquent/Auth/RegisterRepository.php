<?php

namespace App\Repositories\Eloquent\Auth;

use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Interfaces\Auth\RegisterRepositoryInterface;

class RegisterRepository extends AccountRepository implements RegisterRepositoryInterface
{
    public function __construct()
    {
        parent::__construct();
    }


}
