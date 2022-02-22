<?php

namespace App\Http\Resources\Representation\User;

use App\Models\OrderTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Hekmatinasser\Verta\Verta;

use function Ramsey\Uuid\v1;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         $v = new Verta();
         $v->timestamp($this->startTime);
         $this->startTime = $v->format('l y/n/j ساعت H:i');
         $v2 = new Verta();
         $v2->timestamp($this->endTime);
         $this->endTime = $v2->format('l y/n/j ساعت H:i');
        $allTimes = $this->times->groupBy('group_counter')->map(function ($times) {
            return $times->map(function ($time) {
                $v = new Verta();
                $v->timestamp($time->time);
                $time->persian = $v->format('l y/n/j ساعت H:i');
                return $time;
            });
        });
        $groupCount = count($allTimes);
         $minTime = $this->times()->where('group_counter',$groupCount-1)->orderBy('time')->first()->time ?? NULL;
         $v3 = Verta();
         $v3->timestamp($minTime);
         $minTime = (object)[];
         $minTime->year = $v3->year;
         $minTime->month = $v3->month;
         $minTime->day = $v3->day;
         $minTime->dayOfWeek = $v3->dayOfWeek;
         $minTime->daysInMonth = $v3->daysInMonth;
        $newTimes = $this->times()->where('sender', 'REPRESENTATION')
        ->where('status','PENDING')->where('group_counter',$groupCount-1)->get()->map(function ($dateTime) {
            $v = Verta();
            $v->timestamp($dateTime->time);
            $time = (object)[];
            $time->id = $dateTime->id;
            $time->year = $v->year;
            $time->month = $v->month;
            $time->day = $v->day;
            $time->hour = $v->hour;
            return $time;
        });
        $status = $this->status;
        if ($status == 'SAVE' || $status == 'PAYING' || $status == 'INITIAL_CANCELLATION' || $status == 'FAILED_PAYMENT')
        {
           $this->textStatus = 'NOT_PAYED';
        }
        elseif ($status == 'SUCCESS_PAYMENT')
        {
            if ($this->time_status == 'FIRST_REQUEST' || $this->time_status == 'USER_REQUEST')
            {
                $this->textStatus = 'WAITING_REPRESENTATION';
            }
            elseif ($this->time_status == 'REPRESENTATION_REQUEST')
            {
                $this->textStatus = 'WAITING_USER';
            }
            else
            {
                if ($this->startTime > time())
                {
                    $this->textStatus = 'NOT_STARTED';
                }
                else
                {
                    $this->textStatus = 'DOING';
                }
            }
        }
        else
        {
            $this->textStatus = $status;
        }
         return [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'item_name' => $this->item_name,
            'unit_price' => $this->unit_price,
            'count' => $this->count,
            'amount' => $this->amount,
            'status' => $this->status,
            'textStatus' => $this->textStatus,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'properties' => new OrderPropertiesResource($this->properties),
            'minTime' => $minTime,
            'newTimes' => $newTimes,
            'allTimes' => $allTimes,
        ];
    }
}
