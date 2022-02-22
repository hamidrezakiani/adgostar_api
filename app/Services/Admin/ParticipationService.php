<?php
namespace App\Services\Admin;

use App\Http\Resources\Admin\ParticipationResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ParticipationRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\Facades\DB;

class ParticipationService extends ResponseTemplate
{
    protected $participationRepository;
    protected $productRepository;
    public function __construct(ParticipationRepository $participationRepository)
    {
        $this->participationRepository = $participationRepository;
        $this->productRepository = new ProductRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'executerParticipations')
        {
            $participations = $this->participationRepository->getByExecuterId($search);
            $this->setData(new ParticipationResource($participations));
        }
        elseif($flag == 'all')
        {
            $participations = $this->participationRepository->all();
            $this->setData(new ParticipationResource($participations));
        }else
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
