<?php
namespace App\Services\Representation\Agent;

use App\Http\Resources\Representation\Agent\SubsetSearchResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\RepresentationRepository;

class SubsetService extends ResponseTemplate
{
    protected $representationRepository;
    public function __construct(RepresentationRepository $representationRepository)
    {
        $this->representation = auth('representation')->user();
        $this->representationRepository = $representationRepository;
    }

    public function index($flag)
    {
        if($flag=='search')
        {
            $users = $this->representationRepository->subsets($this->representation->id);
            $this->setData(new SubsetSearchResource($users));
        }
        return $this->response();
    }
}
