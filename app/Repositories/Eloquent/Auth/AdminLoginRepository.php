<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\Admin;
use App\Models\Executer;
use App\Models\Representation;
use App\Models\User;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\Auth\AdminLoginRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminLoginRepository extends BaseRepository implements AdminLoginRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Admin());
    }

    public function checkPassword($phone,$password)
    {
        $admin = $this->model->where('phone',$phone)->first();
        if(Hash::check($password, $admin->password ?? null))
        return $admin;
        else
        return false;
    }

    public function updateToken($admin) : Model
    {
        $admin->api_token = Str::random(60);
        $this->update(['api_token' => $admin->api_token],$admin->id);
        return $admin;
    }
}
