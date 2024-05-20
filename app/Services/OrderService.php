<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    private function getOrder(int $id): ?Order
    {
        return Order::find($id);
    }
    
    public function fetchAllOrders(): Collection
    {
        return auth()->user()->orders;
    }

    public function fetchOrder(int $id): ?Order 
    {
        if (! $order = $this->getOrder($id) ) {
            return null;
        }

        return $order;
    }
}
