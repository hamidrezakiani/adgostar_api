<?php

namespace App\Listeners;

use App\Repositories\Eloquent\ItemRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateFirstItemListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $product = $event->product;
        $product->items()->create([
            'name' => 'اصلی',
            'viewable' => 'YES'
        ]);
    }
}
