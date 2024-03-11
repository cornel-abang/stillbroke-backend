<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Freshbitsweb\LaravelCartManager\Exceptions\ItemMissing;

class CartService
{
    public function __construct()
    {
        cart()->setUser(request()->cart_token);
    }

    public function setCartToken(): void
    {
        cart()->setUser(request()->cart_token);
    }

    public function addItem(array $info): ?bool
    {
        if ($this->itemExists($info['product_id'])) {
            return false;
        }

        if ($this->stockIsLow($info)) {
            return null;
        }

        Product::addToCart($info['product_id'], $info['qty']);

        self::addExtraFieldsToCart($info);

        return true;
    }

    public function getCart(): array
    {
        $cartItems = $this->getRawItems();
        
        if (null === $cartItems) {
            return [];
        }

        $cart = cart()->toArray();
        $cart['items'] = $cartItems->toArray();
        
        return $cart;
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

    public function updateItemQty(array $info): bool
    {
        try {
            cart()->setQuantityAt($info['item_index'], $info['qty']);
        } catch (ItemMissing) {

            return false;
        }

        return true;
    }

    public static function addExtraFieldsToCart(array $fields): void
    {
        DB::table('cart_items')
            ->where('model_id', $fields['product_id'])
            ->update([
                'size' => $fields['size'] ?? null,
                'color' => $fields['color'] ?? null
            ]);
    }

    private function getRawItems(): ?Collection
    {
        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        if (! $cart) {
            return null;
        }

        return DB::table('cart_items')
            ->where('cart_id', $cart->id)
            ->get();
    }

    public function updateCart(array $data): array
    {
        $updateData = collect($data)->except('product_id')->toArray();

        DB::table('cart_items')
            ->where('model_id', $data['product_id'])
            ->update($updateData);

        return $this->getCart();
    }

    public static function clear()
    {
        cart()->setUser(request()->cart_token);

        return cart()->clear();
    }

    public static function updateCartItemsQty(): void
    {
        cart()->setUser(request()->cart_token);

        $instance = new self();
        $cart = $instance->getCart();
        
        foreach ($cart['items'] as $item) {
            $product = Product::find($item->model_id);

            $product->avail_qty = $product->avail_qty - $item->quantity;
            $product->save();
        }
    }

    public function stockIsLow(array $info): bool
    {
        $product = Product::find($info['product_id']);

        return $product->avail_qty >= $info['qty'] ? false : true;
    }

    private function itemExists(int $modelId): bool
    {
        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        if (! $cart) {
            return false;
        }

        return DB::table('cart_items')
            ->where('model_id', $modelId)
            ->where('cart_id', $cart->id)
            ->exists();
    }
}
