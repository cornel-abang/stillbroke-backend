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

    public function addItem(array $info): void
    {
        Product::addToCart($info['product_id'], $info['qty']);

        self::addExtraFieldsToCart($info);
    }

    public function getCart(): array
    {
        $cartItems = $this->getRawItems();
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

    private function getRawItems(): Collection
    {
        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

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
}
