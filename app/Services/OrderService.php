<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function fetchAllOrders(): Collection
    {
        return auth()->user()->orders;
    }

    public function fetchOrder(int $id): ?Order 
    {
        $order = Order::find($id);

        if (! $order) {
            return null;
        }

        return $order;
    }
}
