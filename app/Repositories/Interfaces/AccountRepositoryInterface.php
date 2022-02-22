<?php

namespace App\Repositories\Interfaces;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;

interface AccountRepositoryInterface
{
    public function checkPassword($email,$password);

    public function updateToken($userId) : Model;

    public function removeToken($request) : Bool;

    public function findByPhone($phone) :? Account;

    public function updatePassword($phone,$password) :? Account;
}
