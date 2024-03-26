<?php

namespace App\Listeners;

use Illuminate\Support\Facades\DB;
use App\Events\ProductExtraRemoved;

class ProductExtraRemovedListener
{
    public function handle(ProductExtraRemoved $event): void
    {
        $extra_id = $event->extra_id;
        $prod_id = $event->prod_id;

        $cart = DB::table('carts')
            ->where('auth_user', request()->cart_token)
            ->first();

        $cart_item = DB::table('cart_items')
            ->where('model_id', $prod_id)
            ->where('cart_id', $cart->id)
            ->first();

        if ($cart_item->extra_ids != null) {
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