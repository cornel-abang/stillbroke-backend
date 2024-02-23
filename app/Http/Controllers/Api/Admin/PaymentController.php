<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\PaymentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function getAllPayments(): JsonResponse
    {
        return $this->response(
            true, 'Payments found', 200, 
            $this->paymentService->fetchPayments()
        );
    }
}
