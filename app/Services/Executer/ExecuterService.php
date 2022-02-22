<?php

namespace App\Services\Executer;

use App\Events\FastUserEvent;
use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
use App\Http\Resources\Executer\ExecuterResource;
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

class ExecuterService extends ResponseTemplate
{
    public function __construct()
    {

    }

    public function find()
    {
        $this->setData(new ExecuterResource(auth('executer')->user()));
        return $this->response();
    }
}
