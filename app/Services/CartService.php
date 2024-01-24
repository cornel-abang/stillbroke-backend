<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Freshbitsweb\LaravelCartManager\Exceptions\ItemMissing;

class CartService
{
    public function __construct()
    {
        cart()->setUser(request()->cart_token);
    }

    public function addItem(array $info): void
    {
        Product::addToCart($info['product_id'], $info['qty']);
    }

    public function getCartItems(): array
    {
        return cart()->toArray();
    }

    public function rmvItem(int $index): bool
    {
        try {
            cart()->removeAt($index);
        } catch (ItemMissing) {

            return false;
        }
        
        return true;
    }

    public function updateItemQty(array $info)
    {
        try {
            cart()->setQuantityAt($info['item_index'], $info['qty']);
        } catch (ItemMissing) {

            return false;
        }

        return true;
    }
}
