<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class PaymentService
{
    public function fetchPayments(): array
    {
        $paidOrders = Order::where('payment_ref', '!=', null)->get();

        $payments = $paidOrders->map(function($order) {
            return [
                'payment_ref' => $order->payment_ref,
                'amount' => $order->amount,
                'payment_date' => $order->updated_at,
                'paid_by' => $order->owner->name,
                'paid_for' => 'Order: #__'. $order->payment_ref,
                'payment_gateway' => $order->gateway,
            ];
        })
        ->all();

        return $payments;
    }
}