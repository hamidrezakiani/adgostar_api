<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ItemPeriodRepositoryInterface
{
    public function getByItemId($item_id): ?Collection;
}
