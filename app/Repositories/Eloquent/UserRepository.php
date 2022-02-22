<?php

namespace App\Repositories\Eloquent;

use App\Models\Account;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Auth\AccountService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $representation;
    public function __construct($representation)
    {
        $this->representation = $representation;
        parent::__construct(new User());
    }

    public function findByPhone($phone)
    {
        return $this->model->where('phone',$phone)->where('representation_id',$this->representation->id)->first();
    }

    public function createOrUpdate($phone, $password): User
    {
       if($user = $this->updatePassword($phone,$password))
         return $user;

       $user = $this->model->create([
           'representation_id' => $this->representation->id,
           'phone' => $phone,
           'password' => $password
       ]);

       return $user;
    }

    public function updatePassword($phone, $password): ?User
    {
        if ($user = $this->findByPhone($phone))
        {
            $user->update(['password' => $password]);
            $this->updateToken($user);
        }
        return $user;
    }

    public function updateToken($user) : Model
    {
        $user->api_token = Str::random(60);
        $this->update(['api_token' => $user->api_token],$user->id);
        return $user;
    }

    public function removeToken($request) : Bool
    {
        $api_token = substr($request->header('authorization'),7,strlen($request->header('authorization'))-7);
        $userId = $this->model->where('api_token',$api_token)->first()->id;
        return $this->update(['api_token' => NULL],$userId);
    }
}
