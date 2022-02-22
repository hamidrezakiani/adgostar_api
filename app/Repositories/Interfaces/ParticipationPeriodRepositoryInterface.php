<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ParticipationPeriodRepositoryInterface
{
    public function getParticipationPeriod():?Collection;
    public function getByParticipationId($participation_id):?Collection;
    public function storeParticipationPeriod(array $data);
}
