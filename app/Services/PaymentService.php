<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderProduct;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PaymentService
{
    public function makePaymentFlutterwave(array $info): array
    {
        $order = $this->createOrder($info);

        $reference = Flutterwave::generateReference();

        // temporal user
        $user = User::find($info['user_id']);

        $data = [
            'amount' => $info['amount'],
            'email' => $user->email,
            'tx_ref' => $reference,
            'currency' => "USD",
            'redirect_url' => config('app.payment_confirmation'),
            'customer' => [
                'email' => $user->email,
                "phone_number" => $info['shipping_phone'],
                "name" => $user->name
            ],
            "meta" => [
                "order_id" => $order->id,
            ]
        ];
        
        $payment = Flutterwave::initializePayment($data);
        
        if ($payment['status'] !== 'success') {
            return [false, 'Unable to initialize payment', null];
        }

        return [true, 'Payment successfully initialized', $payment['data']['link']];
    }

    public function makePaymentConfirmationFlutterwave(): bool
    {
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $transaction = Flutterwave::verifyTransaction($transactionID);
        
        if ($transaction['status'] == 'success') {
            $order = Order::find($transaction['data']['meta']['order_id']);
            $order->payment_ref = $transaction['data']['tx_ref'];
            $order->gateway = 'Flutterwave';
            $order->save();

            CartService::updateCartItemsStock();

            CartService::clear();

            return true;
        }

        return false;
    }

    public function makePaymentConfirmationPaystack(array $info): void
    {
        $order = $this->createOrder($info);
        $order->payment_ref = $info['tx_ref'];
        $order->gateway = 'Paystack';
        $order->save();

        CartService::updateCartItemsStock();

        CartService::clear();
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
