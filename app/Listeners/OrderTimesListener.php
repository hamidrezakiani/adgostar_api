<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Models\OrderTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderTimesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        OrderTime::create([
            'order_id' => $event->order->id,
            'sender' => 'USER',
            'time' => $event->order->startTime,
        ]);
    }
}
