<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\UserSearchResource;
use App\Lib\ResponseTemplate;

class UserService extends ResponseTemplate
{
    protected $representation;
    public function __construct()
    {
        $this->representation = auth('representation')->user();
    }

    public function index($flag)
    {
        if($flag=='search')
        {
            $users = $this->representation->users()->select(['id','account_id'])->get();
            $this->setData(new UserSearchResource($users));
        }
        return $this->response();
    }
}
