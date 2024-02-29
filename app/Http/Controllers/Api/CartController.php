<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Requests\RmvFromCartRequest;
use App\Http\Requests\UpdateCartItemQtyRequest;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {
    }

    public function addItemToCart(AddToCartRequest $request): JsonResponse
    {
       $this->cartService->addItem($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Item successfully added to cart'
        ], 200);
    }

    public function getAllCartItems(): JsonResponse
    {
        if (! request()->cart_token || request()->cart_token == '') {
            return response()->json([
                'success' => false,
                'message' => 'Cart token not found in request'
            ], 400);
        }

        $cartItems = $this->cartService->getCart();

        if ([] == $cartItems) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown cart session'
            ], 404);
        }
        
        if ([] == $cartItems['items']) {
            return response()->json([
                'success' => false,
                'message' => 'No items found in your cart'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'total' => $cartItems['netTotal'],
            'cart_items' => $cartItems['items']
        ], 200);
    }

    public function rmvItemFromCart(RmvFromCartRequest $request): JsonResponse
    {
        $response = $this->cartService->rmvItem($request->item_index);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Trying to remove item with wrong index'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ], 200);
    }

    public function updateCartItemQty(UpdateCartItemQtyRequest $request): JsonResponse
    {
        $response = $this->cartService->updateItemQty($request->except('cart_token'));

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Trying to update item quantity with wrong index'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item quantity updated',
        ], 200);
    }

    public function updateCartData(UpdateCartRequest $request): JsonResponse
    {
        $update = $this->cartService->updateCart($request->except('cart_token'));

        return response()->json([
            'success' => true,
            'message' => 'Cart attribute updated',
            'data' => [
                'cart' => $update
            ]
        ], 200);
    }
}