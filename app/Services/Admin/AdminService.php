<?php

namespace App\Services\Admin;

use App\Events\FastUserEvent;
use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
use App\Http\Resources\Admin\AdminResource;
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

class AdminService extends ResponseTemplate
{
    public function __construct()
    {

    }

    public function find()
    {
        $this->setData(new AdminResource(auth('admin')->user()));
        return $this->response();
    }
}
