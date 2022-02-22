<?php

namespace App\Repositories\Interfaces;

use App\Models\Account;
use App\Models\Representation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepresentationRepositoryInterface
{
    public function findByDomain() : ?Representation;

    public function findByUserAuth() : ?Representation;

    public function findByAgentAuth() : ?Representation;

    public function subsets($id) : ?Collection;
}
