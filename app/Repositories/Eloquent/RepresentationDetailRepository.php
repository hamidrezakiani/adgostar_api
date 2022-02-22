<?php

namespace App\Repositories\Eloquent;

use App\Models\RepresentationDetail;
use App\Repositories\Interfaces\RepresentationDetailRepositoryInterface;

class RepresentationDetailRepository extends BaseRepository implements RepresentationDetailRepositoryInterface
{
    private $representation;
    public function __construct($domain = NULL)
    {
        parent::__construct(new RepresentationDetail());
        $this->representation = new RepresentationRepository($domain);
    }

    public function findByUserAuth(): ?RepresentationDetail
    {
        return $this->representation->findByUserAuth()->detail ?? NULL;
    }

    public function findByAgentAuth(): ?RepresentationDetail
    {
        return $this->representation->findByAgentAuth()->detail ?? NULL;
    }

    public function findByDomain(): ?RepresentationDetail
    {
        return $this->representation->findByDomain()->detail ?? NULL;
    }
}
