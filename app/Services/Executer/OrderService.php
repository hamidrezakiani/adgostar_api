<?php

namespace App\Services\Executer;

use App\Events\OrderCreatedEvent;
use App\Http\Resources\Executer\OrderResource;
use App\Http\Resources\Executer\OrdersResource;
use App\Http\Resources\Representation\ItemResource;
use App\Http\Resources\Representation\ServiceResource;
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
        $executer_id = auth('executer')->id();
        switch ($flag) {
            case 'TIMING':
                $orders = $this->orderRepository->executerTimingOrders($executer_id);
                break;
            case 'NOT_STARTED':
                $orders = $this->orderRepository->executerNotStartedOrders($executer_id);
                break;
            case 'DOING':
                $orders = $this->orderRepository->executerDoingOrders($executer_id);
                break;
            case 'FINISHED':
                $orders = $this->orderRepository->executerFinishedOrders($executer_id);
                break;
            case 'CLOSED':
                $orders = $this->orderRepository->executerClosedOrders($executer_id);
                break;
            case 'CANCELED':
                $orders = $this->orderRepository->executerSecondaryCancellationOrders($executer_id);
                break;
            default:
                $orders = $this->orderRepository->executerAllOrders($executer_id);
                break;
        }
        $this->setData(new OrdersResource($orders));
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
