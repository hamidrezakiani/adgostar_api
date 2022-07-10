<?php

namespace App\Services\Representation;

use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
use App\Http\Resources\Representation\ServiceCollection;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;
use App\Repositories\Eloquent\RepresentationRepository;
use App\MicroServices\ProductSearch;
use Exception;
use Illuminate\Support\Facades\DB;

class ServiceService extends ResponseTemplate
{
    protected $itemRepository;
    protected $representationRepository;
    protected $participationPeriodRepository;
    protected $representationItemPeriodRepository;
    protected $productSearch;
    public function __construct($domain)
    {
        $this->itemRepository = new ItemRepository();
        $this->representationItemPeriodRepository = new RepresentationItemPeriodRepository();
        $this->participationPeriodRepository = new ParticipationPeriodRepository();
        $this->representationRepository = new RepresentationRepository($domain);
        $this->representation = $this->representationRepository->findByDomain();
        $this->productSearch = new ProductSearch();
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
      $matchPeriod = $this->participationPeriodRepository
                ->matchPeriod($itemPeriod->item_id, $itemPeriod->start, $itemPeriod->end);     
      
        return $matchPeriod->cost;
    }

    public function itemPeriods($item_id,$domain)
    {
        $maxOrder =  $this->participationPeriodRepository->maxOrder($item_id);
        $rPeriods  = $this->representationItemPeriodRepository->getByItemId($this->representation->id, $item_id);
        $rPeriods = $rPeriods->map(function ($rPeriod) use ($maxOrder) {
            $rPeriod->baseCost = $this->baseCost($rPeriod->itemPeriod, $this->representation);
            $rPeriod->cost = round($rPeriod->baseCost * (1 + $rPeriod->userProfit / 100));
            if ($rPeriod->itemPeriod->end == NULL || $rPeriod->itemPeriod->end > $maxOrder)
                $rPeriod->itemPeriod->end = $maxOrder;
            return $rPeriod;
        });
        return $rPeriods;
    }

    public function index($request)
    {
      if($request->cat_id)
        $products = $this->productSearch->readyService()->searchByCatId($request->cat_id);
      else
        $products = $this->productSearch->readyService()->all();
      
      $domain = $request->domain;
      $products = $products->map(function($product)use($domain){
          $product->items = $product->items()->readyService()->get();
          $product->items = $product->items->map(function($item)use($domain){
             $item->periods = $this->itemPeriods($item->id,$domain);
             $item->maxOrder = $this->participationPeriodRepository->maxOrder($item->id);
             return $item;
          });
          return $product;
      });
      
      $this->setData(new ServiceCollection($products));
      return $this->response();
    }
    

    /*public function show($id,$domain)
    {
       $item = $this->itemRepository->find($id);
       $item->periods = $this->itemPeriods($item->id, $domain);
       $item->maxOrder = $this->participationPeriodRepository->maxOrder($item->id);
       $this->setData(new ItemResource($item));
        return $this->response();
    }*/
}
