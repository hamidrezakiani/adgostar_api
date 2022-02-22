<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ParticipationRepositoryInterface
{
    public function checkParticipation($executer_id,$product_id):?bool;
}
