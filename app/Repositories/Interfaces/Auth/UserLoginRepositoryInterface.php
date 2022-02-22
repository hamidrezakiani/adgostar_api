<?php

namespace App\Repositories\Interfaces\Auth;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserLoginRepositoryInterface
{
    public function checkPassword($email,$password,$representation_id);
    public function updateToken($userId) : Model;
}
