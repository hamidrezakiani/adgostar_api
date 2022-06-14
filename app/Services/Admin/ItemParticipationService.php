<?php
namespace App\Services\Admin;

use App\Repositories\Eloquent\ParticipationRepository;
use Illuminate\Support\Facades\DB;

class ItemParticipationService
{
    protected $participationRepository;
    public function __construct()
    {
        $this->participationRepository = new ParticipationRepository();
    }


    public function update($item_id,$participation_id)
    {
       $this->unassignOld($item_id);
       if($participation_id)
        $this->assign($item_id,$participation_id);
    }
    
    public function assign($item_id,$participation_id)
    {
      $participation = $this->participationRepository->find($participation_id);
      $participation->update(['item_id' => $item_id]);
    }
    
    public function unassignOld($item_id)
    {
      $this->participationRepository->unsyncItem($item_id);
    }
    
}
