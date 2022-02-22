<?php
namespace App\Lib;
class Payment{

    protected $callback,$amount,$order_id,$email,$phone,$name,$description;

    public function __construct($callback = NULL)
    {
        $this->callback = $callback;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPaymentLink()
    {
        $params = array(
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'name' => $this->name,
            'phone' => $this->phone,
            'mail' => $this->email,
            'desc' => $this->description,
            'callback' => $this->callback,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: 6a7f99eb-7c20-4412-a972-6dfb7cd253a4',
            'X-SANDBOX: 1'
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        return $result;
    }

    public function verify($id,$order_id)
    {
        $params = array(
            'id' => $id,
            'order_id' => $order_id,
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.idpay.ir/v1.1/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-API-KEY: 6a7f99eb-7c20-4412-a972-6dfb7cd253a4',
            'X-SANDBOX: 1',
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        return $result;
    }
}
