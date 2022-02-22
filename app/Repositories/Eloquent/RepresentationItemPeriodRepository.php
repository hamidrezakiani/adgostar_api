<?php

namespace App\Repositories\Eloquent;

use App\Models\RepresentationItemPeriod;
use App\Repositories\Interfaces\RepresentationItemPeriodRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RepresentationItemPeriodRepository extends BaseRepository implements RepresentationItemPeriodRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new RepresentationItemPeriod());
    }

    public function getByItemId($representation_id,$item_id)
    {
       return $this->model->where('representation_id',$representation_id)
       ->whereHas('itemPeriod',function($query)use($item_id)
       {
          return $query->whereHas('item',function($query)use($item_id){
              return $query->where('id',$item_id)->whereHas('participation',function($query){
                return $query->whereHas('periods',function($query)
                {
                        return $query->where('end', '>', DB::raw('item_periods.start'));
                });
              });
          });
       })->join('item_periods', 'representation_item_periods.item_period_id', '=', 'item_periods.id')->orderBy('item_periods.start')->get();
    }

    public function findByItemPeriodId($representation_id,$item_period_id)
    {
        return $this->model->where('item_period_id',$item_period_id)
        ->where('representation_id',$representation_id)->first();
    }
}
