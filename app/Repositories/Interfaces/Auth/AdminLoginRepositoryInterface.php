<?php

namespace App\Repositories\Interfaces\Auth;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface AdminLoginRepositoryInterface
{
    public function checkPassword($email,$password);
    public function updateToken($userId) : Model;
}
