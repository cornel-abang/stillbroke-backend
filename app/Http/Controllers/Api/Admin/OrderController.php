<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakePaymentRequest;

class OrderController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function getAllUserOrders(int $id)
    {
        //
    }
}
