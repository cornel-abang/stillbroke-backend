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

    public function rmvItem(int $id): bool
    {
        try {
            cart()->removeAt($id);

            return true;
        } catch (ItemMissing) {
            return false;
        }
    }
}
