<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakePaymentRequest;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function processPayment(MakePaymentRequest $request): JsonResponse
    {
        list($response, $message) = $this->paymentService->makePayment($request->validated());

        if (! $response) {
            return $this->response(false, $message, 404);
        }

        return $this->response(true, $message, 200);
    }
}
