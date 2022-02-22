<?php
namespace App\Services\Executer;

use App\Http\Resources\Executer\CategoryResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ParticipationRepository;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\Facades\DB;

class ParticipationService extends ResponseTemplate
{
    protected $participationRepository;
    protected $productRepository;
    protected $periodService ;
    public function __construct(ParticipationRepository $participationRepository)
    {
        $this->participationRepository = $participationRepository;
        $this->productRepository = new ProductRepository();
    }

    public function index($flag = NULL,$search = NULL)
    {
        if($flag == 'periods')
        {
            $categories = $this->categoryRepository->showParents()->readyService();
            $this->setData(new CategoryResource($categories));
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($request,$id)
    {
        $periodService = new PeriodService($id);
        $periodService->update($request->periodArray, $id);
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
          $participation = $this->participationRepository->create([
             'executer_id' => auth('executer')->id(),
             'product_id' => $product->id
           ]);
           $periodService = new PeriodService($participation->id);
           $periodService->store($request->periodArray,$participation->id);
        $this->setData($participation);
       $this->setStatus(200);
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
