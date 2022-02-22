<?php

namespace App\Services\Representation;

use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;

class CalculateService
{
    protected $productRepository;
    protected $itemRepository;
    protected $categoryRepository;
    protected $representationRepository;
    protected $participationPeriodRepository;
    protected $representationItemPeriodRepository;

    public function __construct()
    {
        $this->representationItemPeriodRepository = new RepresentationItemPeriodRepository();
        $this->participationPeriodRepository = new ParticipationPeriodRepository();
    }

    public function representationPeriodCost($itemPeriod, $representation)
    {
        $rPeriod = $this->representationItemPeriodRepository->findByItemPeriodId($representation->id, $itemPeriod->id);
        $baseCost = $this->baseCost($rPeriod->itemPeriod, $representation);
        $cost = round($baseCost * (1 + $rPeriod->userProfit / 100));
        return $cost;
    }

    public function baseCost($itemPeriod, $representation)
    {
        if ($representation->parent) {
            $rPeriod = $this->representationItemPeriodRepository->findByItemPeriodId($representation->parent->id, $itemPeriod->id);
            if ($representation->kind == 'SPECIAL') {
                return round((1 + $rPeriod->seniorRepresentationProfit / 100) *
                    $this->baseCost($itemPeriod, $representation->parent));
            } else {
                return round((1 + $rPeriod->normalRepresentationProfit / 100) *
                    $this->baseCost($itemPeriod, $representation->parent));
            }
        }
        return $this->participationPeriodRepository
            ->matchPeriod($itemPeriod->item_id, $itemPeriod->start, $itemPeriod->end)
            ->cost;
    }

    public function orderBaseCost($item_id,$representation,$count)
    {
        $unit_price = $this->itemUnitPrice($item_id,$representation,$count);
        $amount = $unit_price * $count;
        return $amount;
    }

    public function itemUnitPrice($item_id,$representation,$count)
    {
       $itemRepository = new ItemRepository($item_id);
       $matchPeriod = $itemRepository->matchPeriod($count);
       return $this->representationPeriodCost($matchPeriod, $representation);
    }


    public function getOrderExecuteTime($item_id,$count)
    {
        $itemRepository = new ItemRepository($item_id);
        $matchPeriod = $itemRepository->matchPeriod($count);
        return $matchPeriod->time;
    }
}
