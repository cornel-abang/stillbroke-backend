<?php

namespace App\Listeners;

use App\Events\PaymentMadeEvent;
use App\Models\Order;
use App\Models\OrderProduct;

class PaymentMadeListener
{
    public function handle(PaymentMadeEvent $event): void
    {
        cart()->setUser($event->info['cart_token']);

        $order = $this->createOrder($event);

        $this->attachOrderItems($order->id);
    }

    private function createOrder(PaymentMadeEvent $event)
    {
        return Order::create([
            'user_id' => $event->info['user_id'],
            'amount' => $event->info['amount'],
            'payment_ref' => $event->info['payment_ref'],
            'receipt_url' => $event->info['receipt_url']
        ]);
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
