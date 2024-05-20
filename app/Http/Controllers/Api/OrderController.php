<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function getAllUserOrders(): JsonResponse
    {
        $orders = $this->orderService->fetchAllOrders();

        return $this->response(
            true, 'Orders found: '.$orders->count(), 
            200, $orders
        );
    }

    public function getOrder(int $id): JsonResponse
    {
        $order = $this->orderService->fetchOrder($id);

        if (null === $order) {
            return $this->response(
                false, 'Order not found', 404
            );
        }

        return $this->response(
            true, 'Order found', 
            200, $order
        );
    }
}
