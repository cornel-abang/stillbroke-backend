<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $products = $this->map(function ($product) {

            $images = $product->images->map(function ($image) {
                return $image->url;
            });

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'color' => $product->color,
                'description' => $product->description,
                'images' => $images,
            ];

        })->all();

        return $products;
    }
}
