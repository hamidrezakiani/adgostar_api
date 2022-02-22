<?php

namespace App\Repositories\Eloquent;

use App\Models\ParticipationPeriod;
use App\Repositories\Interfaces\ParticipationPeriodRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ParticipationPeriodRepository extends BaseRepository implements ParticipationPeriodRepositoryInterface
{
    public $participation_id;
    public function __construct($participation_id = NULL)
    {
        $this->participation_id = $participation_id;
        parent::__construct(new ParticipationPeriod());
    }

    public function getParticipationPeriod(): ?Collection
    {
        return $this->model->where('participation_id', $this->participation_id)->get();
    }

    public function getByParticipationId($participation_id) :?Collection
    {
        return $this->model->where('participation_id', $participation_id)->get();
    }

    function storeParticipationPeriod($data)
    {

    }

    public function matchPeriod($item_id,$start,$end)
    {
       $middle = (int) (($start + $end)/2);
       return $this->model->whereHas('participation',function($subQuery)use($item_id){
           return $subQuery->where('item_id',$item_id);
       })->where('start','<=',$middle)->orderBy('start','DESC')->first();
    }

    public function maxOrder($item_id)
    {
        return $this->model->whereHas('participation',function($subQuery)use($item_id){
           return $subQuery->where('item_id',$item_id);
        })->orderBy('end','DESC')->first()->end;
    }
}
