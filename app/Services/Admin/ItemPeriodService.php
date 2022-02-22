<?php
namespace App\Services\Admin;

use App\Events\UpdateItemPeriodEvent;
use App\Http\Resources\Admin\ItemPeriodResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ItemPeriodRepository;
use App\Repositories\Eloquent\ItemRepository;

class ItemPeriodService extends ResponseTemplate
{
    protected $itemPeriodRepository;
    protected $itemRepository;

    public function __construct(ItemPeriodRepository $itemPeriodRepository)
    {
        $this->itemPeriodRepository = $itemPeriodRepository;
        $this->itemRepository = new ItemRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'itemPeriods')
        {
            $periods = $this->itemPeriodRepository->getByItemId($search);
            if(sizeof($periods))
              $this->setData(new ItemPeriodResource($periods));
            else
              $this->setStatus(204);
        }
        elseif($flag == 'all')
        {
            $periods = $this->itemPeriodRepository->all();
            if(sizeof($periods))
                $this->setData(new ItemPeriodResource($periods));
            else
                $this->setStatus(204);
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
        $item = $this->itemRepository->find($id);
        $item->periods()->delete();
        foreach (json_decode($request->periodArray) as $period) {
            $item->periods()->create((array) $period);
        }
       event(new UpdateItemPeriodEvent($item));
       $this->setStatus(204);
       return $this->response();
    }

    public function store($request)
    {
        $product = $this->productRepository->find($request->product_id);
        if($this->participationRepository->checkParticipation(auth('executer')->id(),$product->id))
        {
            $this->setStatus(403);
            return $this->response();
        }
        if($product->periodType == 'SINGLE')
        {
            $participation = $this->participationRepository->create([
                'executer_id' => auth('executer')->id(),
                'product_id' => $product->id
            ]);
            $participation->periods()->create([
                'cost' => $request->cost
            ]);
        }
        else
        {
          $participation = $this->participationRepository->create([
             'executer_id' => auth('executer')->id(),
             'product_id' => $product->id
           ]);
           foreach(json_decode($request->periodArray) as $period)
           {
               $participation->periods()->create((array) $period);
           }
        }
       $this->setStatus(204);
       return $this->response();
    }

    public function routePage($parent)
    {
        if($parent)
          return array_merge($this->routePage($parent->parent),[['id' => $parent->id,'name'=>$parent->name]]);
        else
          return [];
    }
}
