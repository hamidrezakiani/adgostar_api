<?php
namespace App\Services\Admin;

use App\Http\Resources\Admin\ParticipationPeriodCollection;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;

class ParticipationPeriodService extends ResponseTemplate
{
    protected $participationPeriodRepository;
    protected $itemRepository;

    public function __construct(ParticipationPeriodRepository $participationPeriodRepository)
    {
        $this->participationPeriodRepository = $participationPeriodRepository;
        $this->itemRepository = new ItemRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'participationPeriods')
        {
            $periods = $this->participationPeriodRepository->getByParticipationId($search);
            $this->setData(new ParticipationPeriodCollection($periods));
        }
        elseif($flag == 'all')
        {
            $periods = $this->participationPeriodRepository->all();
            $this->setData(new ParticipationPeriodCollection($periods));
        }
        elseif($flag == 'itemParticipationPeriods')
        {
           $participation = $this->itemRepository->find($search)->participation;
           if($participation)
           {
                $periods = $this->participationPeriodRepository->getByParticipationId($participation->id);
                $this->setData(new ParticipationPeriodCollection($periods));
           }
           else
           {
                $this->setStatus(204);
           }
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
       $this->participationRepository->update($request->all(),$id);
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
