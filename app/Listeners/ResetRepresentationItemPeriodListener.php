<?php

namespace App\Listeners;

use App\Events\UpdateItemPeriodEvent;
use App\Repositories\Eloquent\RepresentationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ResetRepresentationItemPeriodListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $representationRepository;

    public function __construct(RepresentationRepository $representationRepository)
    {
        $this->representationRepository = $representationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $itemPeriods = $event->item->periods;
        $representations = $this->representationRepository->all();
        foreach($representations as $representation)
        {
            $settings = $representation->setting;
            $representation->periods()->old()->delete();
            foreach($itemPeriods as $period)
            {
                $representation->periods()->create([
                    'item_period_id' => $period->id,
                    'seniorRepresentationProfit' => $settings->seniorRepresentationProfit,
                    'normalRepresentationProfit' => $settings->normalRepresentationProfit,
                    'userProfit' => $settings->userProfit
                ]);
            }
        }
    }
}
