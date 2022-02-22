<?php
namespace App\Services\Representation;

use App\Http\Resources\Representation\RepresentationDetailResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\RepresentationDetailRepository;

class RepresentationDetailService extends ResponseTemplate
{
    protected $representationDetailRepository;

    public function __construct(RepresentationDetailRepository $representationDetailRepository)
    {
        $this->representationDetailRepository = $representationDetailRepository;
    }

    public function show($domain = NULL)
    {
       if(auth('representation')->check())
       {
         $detail = $this->representationDetailRepository->findByAgentAuth();
         $this->setData(new RepresentationDetailResource($detail));
       }
       else if(auth('user')->check())
       {
          $detail = $this->representationDetailRepository->findByUserAuth();
          if($detail->representation->status == 'ACTIVE')
            $this->setData(new RepresentationDetailResource($detail));
          else
            $this->setStatus(403);
       }
       else
       {
          $detailRepository = new RepresentationDetailRepository($domain);
          $detail = $detailRepository->findBYDomain();
          if($detail && $detail->representation->status == 'ACTIVE')
            $this->setData(new RepresentationDetailResource($detail));
          else
            $this->setStatus(410);
       }
       return $this->response();
    }
}
