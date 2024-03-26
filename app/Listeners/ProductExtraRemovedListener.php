<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;
use App\Events\ProductExtraRemoved;

class ProductExtraRemovedListener
{
    public function handle(ProductExtraRemoved $event): void
    {
        $extra_id = $event->data['extra_id'];
        $prod_id = $event->data['product_id'];
        $cart_token = $event->data['cart_token'];

        $cart = DB::table('carts')
            ->where('auth_user', $cart_token)
            ->first();

        $cart_item = DB::table('cart_items')
            ->where('model_id', $prod_id)
            ->where('cart_id', $cart->id)
            ->first();
        
        if ($cart_item && $cart_item->extra_ids != null) {
            $extra_ids = collect(explode(",", $cart_item->extra_ids))
                ->filter(function ($id) use ($extra_id) {
                    return $id != $extra_id;
                })
                ->all();

            DB::table('cart_items')
            ->where('model_id', $prod_id)
            ->where('cart_id', $cart->id)
            ->update([
                'extra_ids' => implode(",", $extra_ids)
            ]);
        }
    }
}