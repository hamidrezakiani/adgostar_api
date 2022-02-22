<?php

namespace App\Repositories\Interfaces;

use App\Models\RepresentationDetail;
use App\Repositories\Eloquent\RepresentationRepository;
use Illuminate\Database\Eloquent\Model;

interface RepresentationDetailRepositoryInterface
{
    public function findByUserAuth() : ?RepresentationDetail;
    public function findByAgentAuth() : ?RepresentationDetail;
    public function findByDomain() :?RepresentationDetail;
}
