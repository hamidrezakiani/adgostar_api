<?php

namespace App\Listeners;

use App\Events\OrderPayedSuccess;
use App\Models\Executer;
use App\Models\ExecuterTransaction;
use App\Models\Test;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\ParticipationRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExecuterProfitListener
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
     * @param  OrderPayedSuccess  $event
     * @return void
     */
    public function handle(OrderPayedSuccess $event)
    {
        $order = $event->order;
        $participationPeriodRepository = new ParticipationPeriodRepository();
        $period = $participationPeriodRepository->matchPeriod($order->item_id,$order->count,$order->count);
        $amount = $period->cost * $order->count;
        $executer = Executer::find($order->executer_id);
        $executer->balance += $amount;
        $executer->save();
        ExecuterTransaction::create([
            'executer_id' => $order->executer_id,
            'amount' => $amount,
            'type' => 'INCREASE',
            'property' => 'ORDER',
            'property_id' =>  $order->id,
            'status' => 'DOING',
            'balance' => $executer->balance,
            'removable' => $executer->removable
        ]);
    }
}
