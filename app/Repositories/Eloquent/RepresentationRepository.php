<?php

namespace App\Repositories\Eloquent;

use App\Models\Representation;
use App\Repositories\Interfaces\RepresentationRepositoryInterface;
use Carbon\Traits\Test;
use Illuminate\Database\Eloquent\Collection;

class RepresentationRepository extends BaseRepository implements RepresentationRepositoryInterface
{
    private $domain;
    public function __construct($domain = NULL)
    {
        parent::__construct(new Representation());
        $this->domain = $domain;
    }

    public function findByDomain(): ?Representation
    {
        return $this->model->where('domain',$this->domain)->first();
    }

    public function findByUserAuth(): ?Representation
    {
        return auth('user')->user()->representation ?? NULL;
    }

    public function findByAgentAuth(): ?Representation
    {
        return auth('representation')->user() ?? NULL;
    }

    public function subsets($id) :?Collection
    {
        return $this->model->where('parent_id',$id)->get();
    }
}
