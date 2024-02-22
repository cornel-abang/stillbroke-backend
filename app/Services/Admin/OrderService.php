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
}
