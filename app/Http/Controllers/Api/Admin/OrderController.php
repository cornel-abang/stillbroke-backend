<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function getAllOrders()
    {
        return $this->response(
            true, 'Orders found', 200, 
            $this->orderService->fetchAllOrders()
        );
    }
}
