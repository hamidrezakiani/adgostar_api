<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    protected $paymentService;

    public function __construct()
    {
        $this->paymentService = new PaymentService();
    }

    public function create(Request $request)
    {
       return $this->paymentService->create($request->propertyType,$request->propertyId, $_SERVER['HTTP_REFERER'],$request->ip());
    }

    public function verify(Request $request)
    {
        return $this->paymentService->verify($request);
    }
}
