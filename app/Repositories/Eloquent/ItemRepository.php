<?php

namespace App\Repositories\Eloquent;

use App\Models\Item;
use App\Models\ItemPeriod;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ItemRepository extends BaseRepository implements ItemRepositoryInterface
{
    protected $item;

    public function __construct($id = NULL)
    {
        parent::__construct(new Item());
        $this->item = $this->model->find($id);
    }

    public function viewable() :?Collection
    {
        return $this->model->where('viewable','YES')->get();
    }

    public function getViewableByProduct($product_id) :?Collection
    {
        return $this->model->where('viewable','YES')
        ->where('product_id',$product_id)->get();
    }

    public function getByProduct($product_id) :?Collection
    {
        return $this->model->where('product_id',$product_id)->get();
    }

    public function getExecuter()
    {
        return $this->item->participation->executer;
    }

    public function getProduct()
    {
        return $this->item->product;
    }

    public function matchPeriod($count):?ItemPeriod
    {
        return $this->item->periods()
        ->where('start', '<=', $count)
            ->where('end', '>=', $count)->first();
    }
}
