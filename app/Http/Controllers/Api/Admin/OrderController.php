<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function getAllOrders(): JsonResponse
    {
        return $this->response(
            true, 'Orders found', 200, 
            $this->orderService->fetchAllOrders()
        );
    }

    public function getOrderItems(int $id): JsonResponse
    {
        $orderItems = $this->orderService->fetchOrderItems($id);

        if (null === $orderItems) {
            return $this->response(
                false, 'Order not found', 404
            );
        }

        return $this->response(
            true, 'Order items found', 
            200, $orderItems
        );
    }

    public function getOrderDetailsByRef(string $ref)
    {
        $orderDetails = $this->orderService->fetchOrderByRef($ref);

        if (null === $orderDetails) {
            return $this->response(
                false, 'Order not found', 404
            );
        }

        return $this->response(
            true, 'Order details found', 
            200, $orderDetails
        );
    }
}
