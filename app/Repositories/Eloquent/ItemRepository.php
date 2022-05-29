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
        return $this->model->where('product_id',$product_id)->orderBy('tab_index','ASC')->get();
    }

    public function getExecuter()
    {
        return $this->item->participation->executer;
    }

    public function getProduct()
    {
        return $this->item->product;
    }
    
    public function previous($id)
    {
      $item = $this->model->find($id);
      return $this->model->where('product_id',$item->product_id)
        ->where('tab_index','<',$item->tab_index)
          ->orderBy('tab_index','DESC')->first();
    }
    
    public function next($id)
    {
      $item = $this->model->find($id);
      return $this->model->where('product_id',$item->product_id)
        ->where('tab_index','>',$item->tab_index)
          ->orderBy('tab_index','ASC')->first();
    }

    public function matchPeriod($count):?ItemPeriod
    {
        return $this->item->periods()
        ->where('start', '<=', $count)
            ->where('end', '>=', $count)->first();
    }
}
