<?php

namespace App\Listeners;

use App\Repositories\Eloquent\ItemPeriodRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateFirstPeriodListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

     protected $itemPeriodRepository;

    public function __construct(ItemPeriodRepository $itemPeriodRepository)
    {
        $this->itemPeriodRepository = $itemPeriodRepository;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $item = $event->item;
        $item->periods()->create([
            'start' => 1,
            'end' => NULL,
            'time' => 24
        ]);
    }
}
