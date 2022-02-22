<?php

namespace App\Repositories\Eloquent;

use App\Models\ItemPeriod;
use App\Repositories\Interfaces\ItemPeriodRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ItemPeriodRepository extends BaseRepository implements ItemPeriodRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new ItemPeriod());
    }

    public function getByItemId($item_id): ?Collection
    {
        return $this->model->where('item_id',$item_id)->orderBy('start')->get();
    }
}
