<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Participation;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ParticipationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ParticipationRepository extends BaseRepository implements ParticipationRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Participation());
    }

    public function checkParticipation($executer_id, $product_id): ?bool
    {
        if($this->model->where('executer_id',$executer_id)->where('product_id',$product_id)->first())
          return true;
        else
          return false;
    }
    
    public function getByItemId($item_id):?Participation
    {
       return $this->model->where('item_id',$item_id)->first();
    }
    
    public function getByProductId($product_id):?Collection
    {
       return $this->model->where('product_id',$product_id)->get();
    }
    
    public function unsyncItem($item_id)
    {
      return $this->model->where('item_id',$item_id)->update(['item_id' => NULL]);
    }

}
