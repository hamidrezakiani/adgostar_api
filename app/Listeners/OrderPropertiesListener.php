<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Services\Representation\OrderPropertyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPropertiesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $orderPropertyService;

    public function __construct()
    {
        $this->orderPropertyService = new OrderPropertyService();
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
       $this->orderPropertyService->store($event->order,$event->properties);
    }
}
