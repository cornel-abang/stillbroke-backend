<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakePaymentRequest;
use App\Http\Requests\ConfirmPaymentRequest;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function processPayment(MakePaymentRequest $request): JsonResponse
    {
        list($response, $message, $payUrl) = $this->paymentService->makePayment($request->validated());

        if (! $response) {
            return $this->response(false, $message, 500);
        }

        return $this->response(true, $message, 200, ['payment_url' => $payUrl]);
    }

    public function confirmPayment(ConfirmPaymentRequest $request)
    {
        if ($request->status !== 'success') {
            return $this->response(false, 'Payment unsuccessful', 500);
        }

        $response = $this->paymentService->makePaymentConfirmation();

        if (! $response) {
            return $this->response(false, 'Payment unsuccessful', 500);
        }

        return $this->response(true, 'Payment successful', 200);
    }
}
