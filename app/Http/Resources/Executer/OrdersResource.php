<?php

namespace App\Http\Resources\Executer;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Hekmatinasser\Verta\Verta;
class OrdersResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($data){
            $order = (object)[];
            $order->id = $data->id;
            $order->name = $data->item->alias;
            $order->count = $this->periodFormat($data->count);;
            $order->amount = $data->executerTransaction->amount;
            $order->times = $data->times()->where('group_counter',$data->times()->orderBy('group_counter','DESC')->first()->group_counter)->get()->map(function($data){
                $time = (object)[
                    'start' => (object)[],
                    'end' => (object)[]
                ];
                $StartTimeStamp = $data->time;
                $timeLeft = $data->order->item->periods()->where('start','<=',$data->order->count)->where('end','>=',$data->order->count)->first()->time;
                $endTimeStamp = $StartTimeStamp + ($timeLeft * 3600);
                $verta = new Verta();
                $verta->timestamp($StartTimeStamp);
                $time->start->year = $verta->year;
                $time->start->month = $verta->month;
                $time->start->day = $verta->day;
                $time->start->hour = $verta->hour;
                $verta = new Verta();
                $verta->timestamp($endTimeStamp);
                $time->end->year = $verta->year;
                $time->end->month = $verta->month;
                $time->end->day = $verta->day;
                $time->end->hour = $verta->hour;
                return $time;
            });
            $status = $data->status;
            if($status == 'SUCCESS_PAYMENT')
            {
                if($data->time_status == 'FIRST_REQUEST')
                {
                   $order->status = 'NEW';
                }
                elseif($data->time_status == 'REPRESENTATION_REQUEST')
                {
                   $order->status = 'TIME_SUGGEST';
                }
                elseif($data->time_status == 'USER_REQUEST')
                {
                   $order->status = 'TIME_REJECTED';
                }
                else
                {
                    if($data->startTime > time())
                    {
                        $order->status = 'TODO';
                    }
                    elseif($data->endTime > time())
                    {
                        $order->status = 'DONE';
                    }
                    else
                    {
                        $order->status = 'DOING';
                    }

                }
            }
            elseif($status == 'SECONDARY_CANCELLATION')
            {
                $order->status = 'CANCELLED';
            }
            else
            {
                $order->status = $status;
            }

            return $order;
        });
    }

    public function periodFormat($count)
    {
        if ($count > 999999 && $count != NULL) {
            $count = round($count / 1000000, 1) . "M";
        } elseif ($count > 999 && $count != NULL) {
            $count = round($count / 1000, 1) . "K";
        }
        return $count;
    }
}
