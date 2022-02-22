<?php

namespace App\Services\Representation\User;

use App\Events\FastUserEvent;
use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
use App\Http\Resources\Representation\User\UserResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;
use App\Repositories\Eloquent\RepresentationRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Representation\CalculateService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService extends ResponseTemplate
{
    public function __construct($domain = NULL)
    {
        if($domain)
        {
            $this->representationRepository = new RepresentationRepository($domain);
            $this->representation = $this->representationRepository->findByDomain();
        }
    }

    public function fastUser($phone)
    {
       $userRepository = new UserRepository($this->representation);
       $password = Str::random(8);
       $user = $userRepository->createOrUpdate($phone,$password);
       event(new FastUserEvent($user,$password));
       return $user;
    }

    public function find()
    {
        $this->setData(new UserResource(auth('user')->user()));
        return $this->response();
    }
}
