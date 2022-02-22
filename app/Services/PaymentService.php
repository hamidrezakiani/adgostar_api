<?php

namespace App\Services;

use App\Events\OrderPayedSuccess;
use App\Lib\Payment;
use App\Models\Order;
use App\Models\Payment as ModelsPayment;
use App\Repositories\Eloquent\OrderRepository;
use Illuminate\Http\Request;

class PaymentService
{

   protected $payment;

    public function __construct()
    {
        $this->payment = new Payment(env('API_URL').'/payment/verify');
    }

   public function create($propertyType,$propertyId,$host,$ip)
   {
       switch($propertyType)
       {
           case 'ORDER':
           $amount =  $this->getDataFromOrder($propertyId);
            break;
           case 'PANEL':

            break;
           case 'WALLET':

            break;
       }
       $order =  ModelsPayment::create([
         'propertyType' => $propertyType,
         'host' => $host,
         'ip' => $ip,
         'property_id' => $propertyId,
         'amount' => $amount,
         'bank' => 'IDPAY',
         'status' => 'PAYING',
       ]);
       $this->payment->setOrderId($order->id);
       $this->payment->setAmount($amount);
       $result = $this->payment->getPaymentLink();
       $order->update([
           'payment_id' => $result->id,
       ]);
       return redirect($result->link);
   }

   public function verify($request)
   {
       if($request->status != 10)
         $status = 'FAILED_PAYMENT';
       else
         $status = 'PAYING';

       switch($request->status)
       {
           case 10:
            $status = 'PAYING';
            break;
           case 7:
            $status = 'INITIAL_CANCELLATION';
            break;
           default:
            $status = 'FAILED_PAYMENT';
           break;
       }
       $order = ModelsPayment::find($request->order_id);
       $order->property()->update([
           'status' => $status
       ]);
       $order->update([
           'status' => $status,
           'status_code' => $request->status,
           'track_id' => $request->track_id,
           'card_number' => $request->card_no,
           'hashed_card_number' => $request->hashed_card_no,
           'date' => $request->date
       ]);

       if($request->status != 10)
       {
           switch($order->propertyType)
           {
               case 'ORDER':
                return redirect($order->host.'page/second-level?order_id='.$order->property_id);
                break;
               case 'PANEL':

                break;
               case 'WALLET':

                break;
               default:
                break;
           }
       }
       else
       {
          $result = $this->payment->verify($request->id,$request->order_id);
          $payment = ModelsPayment::where('id',$result->order_id)
          ->where('payment_id',$result->id)->where('track_id',$result->track_id)
          ->where('amount',$result->amount)->first();
          if($payment)
          {
             if($result->status == 100)
             {
                $payment->update([
                    'status_code' => 100,
                    'status' => 'SUCCESS_PAYMENT'
                ]);

                $payment->property()->update([
                    'status' => 'SUCCESS_PAYMENT'
                ]);
                event(new OrderPayedSuccess(Order::find($payment->property_id)));
             }
             else
             {
                $payment->update([
                    'status_code' => $result->status,
                    'status' => 'FAILED_PAYMENT'
                ]);

                $payment->property()->update([
                    'status' => 'FAILED_PAYMENT'
                ]);
             }
                switch ($order->propertyType) {
                    case 'ORDER':
                        return redirect($order->host . 'page/second-level?order_id=' . $order->property_id);
                        break;
                    case 'PANEL':

                        break;
                    case 'WALLET':

                        break;
                    default:
                        break;
                }
          }
       }
   }

   public function getDataFromOrder($id)
   {
      $orderRepository = new OrderRepository();
      $order = $orderRepository->find($id);
      return $order->bank_payment;
   }
}
