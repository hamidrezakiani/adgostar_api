<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\Admin;
use App\Models\Executer;
use App\Models\Representation;
use App\Models\User;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\Auth\AdminLoginRepositoryInterface;
use App\Repositories\Interfaces\Auth\ExecuterLoginRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ExecuterLoginRepository extends BaseRepository implements ExecuterLoginRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Executer());
    }

    public function checkPassword($phone,$password)
    {
        $executer = $this->model->where('phone',$phone)->first();
        if(Hash::check($password, $executer->password ?? null))
        return $executer;
        else
        return false;
    }

    public function updateToken($executer) : Model
    {
        $executer->api_token = Str::random(60);
        $this->update(['api_token' => $executer->api_token], $executer->id);
        return $executer;
    }
}
