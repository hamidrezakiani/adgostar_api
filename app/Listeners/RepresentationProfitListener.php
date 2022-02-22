<?php

namespace App\Listeners;

use App\Events\OrderPayedSuccess;
use App\Models\ItemPeriod;
use App\Models\Representation;
use App\Models\RepresentationTransaction;
use App\Models\Test;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;
use App\Services\Representation\Agent\RepresentationItemPeriodService;
use App\Services\Representation\CalculateService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RepresentationProfitListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public $representationItemPeriodService;

    public function __construct(RepresentationItemPeriodService $representationItemPeriodService)
    {
        $this->representationItemPeriodService = $representationItemPeriodService;
    }

    /**
     * Handle the event.
     *
     * @param  OrderPayedSuccess  $event
     * @return void
     */
    public function handle(OrderPayedSuccess $event)
    {
        $order = $event->order;
        $representation = $order->representation;
        $itemPeriod = ItemPeriod::where('item_id',$order->item_id)
        ->where('start','<=',$order->count)->where('end','>=',$order->count)->first();
        $baseCost = $this->representationItemPeriodService->baseCost($itemPeriod,$representation) * $order->count;
        $profit = $order->amount - $baseCost;
        $representation = Representation::find($representation->id);
        $representation->balance += $profit;
        $representation->save();
        RepresentationTransaction::create([
            'representation_id' => $representation->id,
            'amount' => $profit,
            'type' => 'INCREASE',
            'property' => 'ORDER',
            'property_id' => $order->id,
            'status' => 'DOING',
            'balance' => $representation->balance,
            'removable' => $representation->removable
        ]);
        if($representation->parent)
        {
            $order->amount = $baseCost;
            $this->subsetProfit($representation->parent,$order);
        }
    }

    public function subsetProfit($representation,$order)
    {
        $itemPeriod = ItemPeriod::where('item_id', $order->item_id)
            ->where('start', '<=', $order->count)->where('end', '>=', $order->count)->first();
        $baseCost = $this->representationItemPeriodService->baseCost($itemPeriod, $representation) * $order->count;
        $profit = $order->amount - $baseCost;
        $representation = Representation::find($representation->id);
        $representation->balance += $profit;
        $representation->save();
        RepresentationTransaction::create([
            'representation_id' => $representation->id,
            'amount' => $profit,
            'type' => 'INCREASE',
            'property' => 'SUBSET_ORDER',
            'property_id' => $order->id,
            'status' => 'DOING',
            'balance' => $representation->balance,
            'removable' => $representation->removable
        ]);
        if ($representation->parent) {
            $order->amount = $baseCost;
            $this->subsetProfit($representation->parent, $order);
        }
    }
}
