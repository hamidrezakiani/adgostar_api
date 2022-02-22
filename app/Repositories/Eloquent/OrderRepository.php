<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    protected $order;

    public function __construct($id = NULL)
    {
        parent::__construct(new Order());
        $this->order = $this->model->find($id);
    }

    public function userAllOrders($user_id)
    {
        return $this->model->where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();
    }

    public function userUnpaidOrders($user_id)
    {
        return $this->model->where('user_id',$user_id)->whereIn('status',
        ['SAVE','PAYING','INITIAL_CANCELLATION','FAILED_PAYMENT'])
        ->orderBy('created_at', 'DESC')->get();
    }

    public function userTimingOrders($user_id)
    {
        return $this->model->where('user_id', $user_id)
        ->where('status','SUCCESS_PAYMENT')
        ->where('time_status','!=','CONFIRMED')->orderBy('created_at', 'DESC')->get();
    }

    public function userNotStartedOrders($user_id)
    {
        return $this-> model->where('user_id', $user_id)
        ->where('status','SUCCESS_PAYMENT')
        ->where('time_status','CONFIRMED')
        ->where('startTime','>',time())->orderBy('created_at', 'DESC')->get();
    }

    public function userDoingOrders($user_id)
    {
        return $this-> model->where('user_id', $user_id)
        ->where('status', 'SUCCESS_PAYMENT')
        ->where('time_status', 'CONFIRMED')
        ->where('startTime', '<', time())->orderBy('created_at', 'DESC')->get();
    }

    public function userFinishedOrders($user_id)
    {
        return $this-> model->where('user_id', $user_id)
        ->where('status', 'COMPLETE')->orderBy('created_at', 'DESC')->get();
    }

    public function userSecondaryCancellationOrders($user_id)
    {
        return $this->model->where('user_id', $user_id)
        ->where('status', 'SECONDARY_CANCELLATION')->orderBy('created_at', 'DESC')->get();
    }

    public function executerAllOrders($executer_id)
    {
        return $this->model->whereIn('status', ['SUCCESS_PAYMENT','COMPLETE','CLOSED','SECONDARY_CANCELLATION'])
        ->where('executer_id', $executer_id)->orderBy('created_at','DESC')->get();
    }

    public function executerTimingOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'SUCCESS_PAYMENT')
            ->where('time_status', '!=', 'CONFIRMED')->orderBy('created_at', 'DESC')->get();
    }

    public function executerNotStartedOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'SUCCESS_PAYMENT')
            ->where('time_status', 'CONFIRMED')
            ->where('startTime', '>', time())->orderBy('created_at', 'DESC')->get();
    }

    public function executerDoingOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'SUCCESS_PAYMENT')
            ->where('time_status', 'CONFIRMED')
            ->where('startTime', '<', time())->orderBy('created_at', 'DESC')->get();
    }

    public function executerFinishedOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'COMPLETE')->orderBy('created_at', 'DESC')->get();
    }

    public function executerClosedOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'CLOSED')->orderBy('created_at', 'DESC')->get();
    }

    public function executerSecondaryCancellationOrders($executer_id)
    {
        return $this->model->where('executer_id', $executer_id)
            ->where('status', 'SECONDARY_CANCELLATION')->orderBy('created_at', 'DESC')->get();
    }

}
