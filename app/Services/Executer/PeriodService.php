<?php
namespace App\Services\Executer;

use App\Http\Resources\Executer\PeriodResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\ParticipationRepository;

class PeriodService extends ResponseTemplate
{
    protected $participationRepository;
    protected $periodRepository;
    public function __construct($participation_id = NULL)
    {
        $this->participationRepository = new ParticipationRepository();
        $this->periodRepository = new ParticipationPeriodRepository($participation_id);
    }

    public function index($flag = NULL)
    {
        if($flag == 'all')
        {
            $periods = $this->periodRepository->getParticipationPeriod();
            $this->setData(new PeriodResource($periods));
        }
        else
        {
            $this->setStatus(403);
        }
        return $this->response();
    }

    public function update($periodArray, $participation_id)
    {
        $participation = $this->participationRepository->find($participation_id);
        $participation->periods()->delete();
        foreach (json_decode($periodArray) as $period) {
            $participation->periods()->create((array) $period);
        }
        $this->setStatus(204);
        return $this->response();
    }

    public function store($periodArray,$participation_id)
    {
       $participation = $this->participationRepository->find($participation_id);
       foreach(json_decode($periodArray) as $period)
       {
          $participation->periods()->create((array) $period);
       }
       $this->setStatus(204);
       return $this->response();
    }
}
