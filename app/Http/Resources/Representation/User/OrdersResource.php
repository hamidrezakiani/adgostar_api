<?php

namespace App\Http\Resources\Representation\User;

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
            $order->product_name = $data->product_name;
            $order->item_name = $data->item_name;
            $order->count = $this->periodFormat($data->count);;
            $order->amount = $data->amount;
            $status = $data->status;
            if($status=='SAVE'||$status=='PAYING'||$status=='INITIAL_CANCELLATION'||$status=='FAILED_PAYMENT')
            {
                $order->status = 'NOT_PAYED';
            }
            elseif($status == 'SUCCESS_PAYMENT')
            {
                if($data->time_status == 'FIRST_REQUEST'||$data->time_status=='USER_REQUEST')
                {
                   $order->status = 'WAITING_REPRESENTATION';
                }
                elseif($data->time_status == 'REPRESENTATION_REQUEST')
                {
                   $order->status = 'WAITING_USER';
                }
                else
                {
                    if($data->startTime > time())
                    {
                        $order->status = 'NOT_STARTED';
                    }
                    else
                    {
                        $order->status = 'DOING';
                    }

                }
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
