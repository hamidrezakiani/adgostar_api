<?php
namespace App\Services\Admin;

use App\Http\Resources\Admin\ParticipationCollection;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ParticipationRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\ItemRepository;
use Illuminate\Support\Facades\DB;

class ParticipationService extends ResponseTemplate
{
    protected $participationRepository;
    protected $productRepository;
    protected $itemRepository;
    public function __construct(ParticipationRepository $participationRepository)
    {
        $this->participationRepository = $participationRepository;
        $this->productRepository = new ProductRepository();
        $this->itemRepository = new ItemRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'executerParticipations')
        {
            $participations = $this->participationRepository->getByExecuterId($search);
            $this->setData(new ParticipationCollection($participations));
        }
        elseif($flag == 'productParticipations')
        {
            $participations = $this->participationRepository->getByProductId($search);
            $this->setData(new ParticipationCollection($participations));
        }
        elseif($flag == 'itemParticipationRequests')
        {
            $product_id = $this->itemRepository->find($search)->product_id;
            $participations = $this->participationRepository->getByProductId($product_id);
            $this->setData(new ParticipationCollection($participations));
        }
        elseif($flag == 'all')
        {
            $participations = $this->participationRepository->all();
            $this->setData(new ParticipationCollection($participations));
        }else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }
    
    

   /* public function update($request,$id)
    {
       $this->participationRepository->update($request->all(),$id);
       $this->setStatus(204);
       return $this->response();
    }*/

    /*public function store($request)
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
    }*/
}
