<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function fetchAllOrders(): Collection
    {
        return Order::all();
    }

    public function fetchOrderItems(int $id): Order | null
    {
        $order = Order::find($id);

        if (! $order ) {
            return null;
        }

        return $order->items;
    }

    public function fetchOrderByRef(string $ref): array | null
    {
        $order = Order::where('payment_ref', $ref)->first();

        if (! $order ) {
            return null;
        }

        $idCounts = $order->items->countBy('id');
        
        $items = $order->items
            ->unique('id')
            ->map(function ($item) use ($idCounts) {
                return $item['title'] ." - (". $idCounts[$item['id']] . ")";
            });

        return [
            'order_by' => $order->owner->name,
            'amount' => $order->amount,
            'payment_ref' => $order->payment_ref,
            'items' => $items
        ];
    }
}
