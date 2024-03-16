<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MakePaymentRequest;
use App\Http\Requests\ConfirmPaymentRequest;
use App\Http\Requests\ConfirmPaystackPaymentRequest;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function processPaymentFlutterwave(MakePaymentRequest $request): JsonResponse
    {
        list($response, $message, $paymentUrl) = $this->paymentService->makePaymentFlutterwave($request->validated());

        if (! $response) {
            return $this->response(false, $message, 500);
        }

        return $this->response(true, $message, 200, ['payment_url' => $paymentUrl]);
    }

    public function confirmPaymentFlutterwave(ConfirmPaymentRequest $request)
    {
        if ($request->status !== 'successful') {
            return $this->response(false, 'Payment unsuccessful', 500);
        }

        $response = $this->paymentService->makePaymentConfirmationFlutterwave();

        if (! $response) {
            return $this->response(false, 'Payment unsuccessful', 500);
        }

        return $this->response(true, 'Payment successful', 200);
    }

    public function confirmPaymentPaystack(ConfirmPaystackPaymentRequest $request)
    {
        $response = $this->paymentService->makePaymentConfirmationPaystack($request->validated());

        return $this->response(true, 'Payment successful', 200);
    }
}
