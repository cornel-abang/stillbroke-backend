<?php

namespace App\Services;

use App\Models\Extra;
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
        
        if (isset($info['extras'])) {
            $extras = implode(",", $info['extras']);
            self::addExtraFieldsToCart($extras, $info['product_id']);
        }

        return true;
    }

    public function getCart(): array
    {
        $cartItems = $this->getRawItems();
        
        if (null === $cartItems) {
            return [];
        }

        $cart = cart()->toArray();

        $cart['items'] = $cartItems;

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
        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        DB::table('cart_items')
            ->where('model_id', $info['product_id'])
            ->where('cart_id', $cart->id)
            ->update([
                'quantity' => $info['qty']
            ]);

        // try {
        //     cart()->setQuantityAt($info['item_index'], $info['qty']);
        // } catch (ItemMissing) {

        //     return false;
        // }

        return true;
    }

    public static function addExtraFieldsToCart(string $extras, $product_id): void
    {
        DB::table('cart_items')
            ->where('model_id', $product_id)
            ->update(['extra_ids' => $extras]);
    }

    private function  getRawItems(): ?Collection
    {
        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        if (! $cart) {
            return null;
        }

        return DB::table('cart_items')
            ->where('cart_id', $cart->id)
            ->get()
            ->map(function ($item) {
                $item->extra_ids = explode(",", $item->extra_ids);
                return $item;
            });
    }

    public function updateCart(array $data): array
    {
        $extra_id = $data['extra_id'];
        $updateData = collect($data)->except('product_id', 'extra_id')->toArray();
        $updateData['extra_ids'] = $extra_id;

        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        $cart_item = DB::table('cart_items')
            ->where('model_id', $data['product_id'])
            ->where('cart_id', $cart->id)
            ->first();

        DB::table('cart_items')
            ->where('model_id', $data['product_id'])
            ->where('cart_id', $cart->id)
            ->update([
                'extra_ids' => $cart_item->extra_ids.','.$extra_id
            ]);

        // if (isset($info['extras'])) {
        //     $extras = implode(",", $info['extras']);
        //     self::addExtraFieldsToCart($extras, $info['product_id']);
        // }

        return $this->getCart();
    }

    /** Update product qty and remove extras */
    public static function updateCartItemsStock(): void
    {
        cart()->setUser(request()->cart_token);

        $instance = new self();
        $cart = $instance->getCart();

        foreach ($cart['items'] as $item) {
            $product = Product::find($item->model_id);

            $product->avail_qty = $product->avail_qty - $item->quantity;
            $product->save();

            $instance->updateProductExtras($product->id);
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

    public function updateProductExtras(int $id)
    {
        $cart = DB::table('cart_items')
            ->where('model_id', $id)
            ->first();

        Extra::whereIn('id', explode(',', $cart->extra_ids))->delete();

        return true;
    }

    /** Clear cart entire content */
    public static function clear()
    {
        cart()->setUser(request()->cart_token);

        return cart()->clear();
    }
}
