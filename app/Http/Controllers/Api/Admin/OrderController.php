<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function getAllUserOrders(int $id)
    {
        $orders = $this->orderService->fetchOrders($id);

        if (! $orders) {
            return $this->response(false, 'User not found', 404);
        }

        return $this->response(true, 'Orders found: '.$orders->count(), 200, $orders);
    }
}
