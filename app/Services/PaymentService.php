<?php

namespace App\Services;

use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\OrderProduct;

class PaymentService
{
    public function makePayment(array $info): array
    {
        cart()->setUser($info['cart_token']);

        Stripe::setApiKey(config('app.stripe_secret'));

        $order = $this->createOrder($info);
        
        try {
            $charge = Charge::create([
                'amount' => $info['amount'],
                'currency' => 'usd',
                'source' => $info['stripeToken'],
                'description' => 'Stillbroke - Payment',
            ]);
            
            if ($charge->paid && $charge->status === 'succeeded') {
                $order->payment_ref = $charge->id;
                $order->receipt_url = $charge->receipt_url;
                $order->save();

                return [true, 'Payment successful'];
            }

            return [false, 'Payment unsuccessful'];
        } catch (\Exception $e) {
            return [false, $e->getMessage()];
        }
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
