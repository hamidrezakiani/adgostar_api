<?php

namespace App\Services\Representation\User;

use App\Events\OrderCreatedEvent;
use App\Http\Resources\Representation\ServiceResource;
use App\Http\Resources\Representation\User\OrderResource;
use App\Http\Resources\Representation\User\OrdersResource;
use App\Lib\ResponseTemplate;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\ItemRepository;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\ParticipationPeriodRepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\RepresentationItemPeriodRepository;
use App\Repositories\Eloquent\RepresentationRepository;
use App\Services\Representation\User\UserService;
use App\Services\Representation\CalculateService;
use App\Services\TimeService;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService extends ResponseTemplate
{
    protected $itemRepository;
    protected $representationRepository;
    protected $representationItemPeriodRepository;
    protected $calculateService;
    protected $orderRepository;
    protected $representation;
    protected $timeService;
    public function __construct($request = NULL)
    {
        $this->representationItemPeriodRepository = new RepresentationItemPeriodRepository();
        $this->participationPeriodRepository = new ParticipationPeriodRepository();
        $this->calculateService = new CalculateService();
        $this->timeService = new TimeService();
        $this->orderRepository = new OrderRepository();
        if($request)
        {
            $this->itemRepository = new ItemRepository($request->item_id);
            $this->representationRepository = new RepresentationRepository($request->domain);
            $this->representation = $this->representationRepository->findByDomain();
        }
    }


    public function index($flag)
    {
        $user_id = auth('user')->id();
        switch ($flag) {
            case 'UNPAID':
                $orders = $this->orderRepository->userUnpaidOrders($user_id);
                break;
            case 'TIMING':
                $orders = $this->orderRepository->userTimingOrders($user_id);
                break;
            case 'NOT_STARTED':
                $orders = $this->orderRepository->userNotStartedOrders($user_id);
                break;
            case 'DOING':
                $orders = $this->orderRepository->userDoingOrders($user_id);
                break;
            case 'FINISHED':
                $orders = $this->orderRepository->userFinishedOrders($user_id);
                break;
            case 'CANCELED':
                $orders = $this->orderRepository->userSecondaryCancellationOrders($user_id);
                break;
            default:
                $orders = $this->orderRepository->userAllOrders($user_id);
                break;
        }
        $this->setData(new OrdersResource($orders));
        return $this->response();
    }


    public function store($request)
    {
       if(auth('user')->check())
       {
            $user = auth('user')->user();
       }
       else
       {
          $userService = new UserService($request->domain);
          $user = $userService->fastUser($request->phone);
       }
        $properties = $request->properties;
        $properties = (array) json_decode($properties);
        $count = $request->count_order;
        $amount = $this->calculateService->orderBaseCost($request->item_id, $this->representation,$count);
        $user_id = $user->id;
        $representation_id = $this->representation->id;
        $item_id = $request->item_id;
        $executer_id = $this->itemRepository->getExecuter()->id;
        $product_name = $this->itemRepository->getProduct()->name;
        $item_name = $this->itemRepository->find($item_id)->name;
        $unit_price = $this->calculateService->itemUnitPrice($item_id,$this->representation,$count);
        $startTime = $this->timeService->changeHour((int)$request->order_date / 1000,$request->order_time);
        $endTime = $this->timeService->sumTime($startTime,$this->calculateService->getOrderExecuteTime($item_id,$count));
        $order = $this->orderRepository->create([
          'item_id' => $item_id,
          'representation_id' => $representation_id,
          'user_id' => $user_id,
          'executer_id' => $executer_id,
          'product_name' => $product_name,
          'item_name' => $item_name,
          'unit_price' => $unit_price,
          'count' => $count,
          'amount' => $amount,
          'bank_payment' => $amount,
          'startTime' => $startTime,
          'endTime' => $endTime,
        ]);
        event(new OrderCreatedEvent($order,$properties));
        $this->setData(['order_id' => $order->id]);
        return $this->response();
    }

    public function show($id)
    {
        $order = $this->orderRepository->find($id);
        $this->setData(new OrderResource($order));
        return $this->response();
    }

    public function update($request,$id)
    {
        if($request->flag == 'REJECT_TIMES')
          $this->rejectAllTimes($id);
        elseif($request->flag=='ACCEPT_TIME')
          $this->acceptTime($id,$request->time_id);
        return $this->response();
    }

    public function acceptTime($id,$time_id)
    {
        $order = $this->orderRepository->find($id);
        $groupTimes = $order->times->groupBy('group_counter');
        if ($groupTimes)
            $lastGroup = $groupTimes[count($groupTimes) - 1];
        else
            $lastGroup = NULL;

        if ($lastGroup) {
            if ($lastGroup[0]['status'] == 'PENDING' && $lastGroup[0]['sender'] == 'REPRESENTATION') {
                $time = $order->times()->where('id',$time_id)->first();
                $order->times()->create([
                    'sender' => 'USER',
                    'time' => $time['time'],
                    'status' => 'ACCEPT',
                    'group_counter' => count($groupTimes),
                ]);
                $endTime = $this->timeService->sumTime($time['time'], $this->calculateService->getOrderExecuteTime($order->item_id, $order->count));
                $order->update([
                    'time_status' => 'CONFIRMED',
                    'startTime' => $time['time'],
                    'endTime' => $endTime
                ]);
            }
        }
    }

    public function rejectAllTimes($id)
    {
        $order = $this->orderRepository->find($id);
        $groupTimes = $order->times->groupBy('group_counter');
        if($groupTimes)
         $lastGroup = $groupTimes[count($groupTimes)-1];
        else
         $lastGroup = NULL;

        if($lastGroup)
        {
            if($lastGroup[0]['status'] == 'PENDING' && $lastGroup[0]['sender'] == 'REPRESENTATION')
            {
              $order->update([
                  'time_status' => 'USER_REQUEST'
              ]);
              foreach($lastGroup as $time)
              {
                  $order->times()->create([
                      'sender' => 'USER',
                      'time' => $time['time'],
                      'status' => 'REJECT',
                      'group_counter' => count($groupTimes),
                  ]);
              }
            }
        }
    }
}
