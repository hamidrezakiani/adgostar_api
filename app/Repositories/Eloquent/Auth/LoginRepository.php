<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\Admin;
use App\Models\Executer;
use App\Models\Representation;
use App\Models\User;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\Auth\LoginRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginRepository extends BaseRepository implements LoginRepositoryInterface
{
    public function __construct($gourd)
    {
        $gourds = [
        'user' => new User(),
        'executer' => new Executer(),
        'admin' => new Admin()
        ];
        parent::__construct($gourds[$gourd]);
    }

    public function checkPassword($phone,$password,$representation_id = NULL)
    {
        $user = $this->model->where('phone',$phone)->first();
        if(Hash::check($password, $user->password ?? null))
        return $user;
        else
        return false;
    }

    public function updateToken($user) : Model
    {
        $user->api_token = Str::random(60);
        $this->update(['api_token' => $user->api_token],$user->id);
        return $user;
    }
}
