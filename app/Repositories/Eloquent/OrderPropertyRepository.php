<?php

namespace App\Repositories\Eloquent;

use App\Models\OrderProperty;
use App\Repositories\Interfaces\OrderPropertyRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderPropertyRepository extends BaseRepository implements OrderPropertyRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new OrderProperty());
    }
}
