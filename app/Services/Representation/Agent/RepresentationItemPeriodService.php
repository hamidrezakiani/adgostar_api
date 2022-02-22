<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\ItemPeriodResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;

class RepresentationItemPeriodService extends ResponseTemplate
{

   protected $representationItemPeriodRepository;
   protected $representation;
   protected $participationPeriodRepository;

  public function __construct(RepresentationItemPeriodRepository $representationItemPeriodRepository)
  {
      $this->representationItemPeriodRepository = $representationItemPeriodRepository;
      $this->participationPeriodRepository = new ParticipationPeriodRepository();
      $this->representation = auth('representation')->user();
  }

  public function index($item_id)
  {
     $maxOrder =  $this->participationPeriodRepository->maxOrder($item_id);
     $rPeriods  = $this->representationItemPeriodRepository->getByItemId($this->representation->id,$item_id);
     $rPeriods = $rPeriods->map(function($rPeriod)use($item_id,$maxOrder){
       $rPeriod->baseCost = $this->baseCost($rPeriod->itemPeriod,$this->representation);
       if($rPeriod->itemPeriod->end == NULL || $rPeriod->itemPeriod->end > $maxOrder)
         $rPeriod->itemPeriod->end = $maxOrder;
       return $rPeriod;
     });
     $this->setData(new ItemPeriodResource($rPeriods));
     return $this->response();
  }

  public function update($data,$id)
  {
      $this->representationItemPeriodRepository->update($data,$id);
      $this->setStatus(204);
      return $this->response();
  }

  public function baseCost($itemPeriod, $representation)
  {
        if($representation->parent)
        {
           $rPeriod = $this->representationItemPeriodRepository->findByItemPeriodId($representation->parent->id,$itemPeriod->id);
           if($representation->kind == 'SPECIAL')
           {
                return round((1 + $rPeriod->seniorRepresentationProfit / 100) *
                    $this->baseCost($itemPeriod, $representation->parent));
           }
           else
           {
                return round((1 + $rPeriod->normalRepresentationProfit / 100) *
                    $this->baseCost($itemPeriod, $representation->parent));
           }

        }
        return $this->participationPeriodRepository
               ->matchPeriod($itemPeriod->item_id, $itemPeriod->start, $itemPeriod->end)
               ->cost;
  }
}
