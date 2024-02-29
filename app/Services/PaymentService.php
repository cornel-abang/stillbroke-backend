<?php

namespace App\Services;

use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\Order;
use App\Models\OrderProduct;

class PaymentService
{
    public function makePayment(array $info): array
    {
        $order = $this->createOrder($info);

        $reference = Flutterwave::generateReference();

        $data = [
            'amount' => $info['amount'],
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'currency' => "USD",
            'redirect_url' => config('app.payment_confirmation'),
            'customer' => [
                'email' => auth()->user()->email,
                "phone_number" => $info['shipping_phone'],
                "name" => auth()->user()->name
            ],
            "metadata" => [
                "order_id" => $order->id,
            ]
        ];
        
        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            return [false, 'Unable to initialize payment', null];
        }

        return [true, 'Payment successfully initialized', $payment['data']['link']];
    }

    public function makePaymentConfirmation(): bool
    {
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $transaction = Flutterwave::verifyTransaction($transactionID);

        if ($transaction['status'] == 'success') {
            $order = Order::find($transaction['data']['metadata']['order_id']);
            $order->payment_ref = $transaction['data']['tx_ref'];
            $order->save();

            /** Clear cart content */
            CartService::clear();

            return true;
        }

        return false;
    }

    private function createOrder(array $info)
    {
        $order = Order::create([
            'user_id' => $info['user_id'],
            'amount' => $info['amount'],
            'shipping_address' => $info['shipping_address'],
            'shipping_phone' => $info['shipping_phone']
        ]);

        $this->attachOrderItems($order->id);

        return $order;
    }

    private function attachOrderItems(int $order_id)
    {
        $cartItems = cart()->toArray();

        foreach ($cartItems['items'] as $item) {
            OrderProduct::create([
                'order_id' => $order_id,
                'product_id' => $item['modelId'],
            ]);
        }
    }
}
