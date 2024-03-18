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
                return [
                    'id' => $image->id,
                    'url' => $image->url
                ];
            });

            $colors = $product->colors->map(function ($color) {
                return [
                    'id' => $color->id,
                    'code' => $color->color_code
                ];
            });

            $sizes = $product->sizes->map(function ($size) {
                return [
                    'id' => $size->id,
                    'code' => $size->size_code
                ];
            });

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'primary_image' => $product->primary_image,
                'gender' => $product->gender,
                'description' => $product->description,
                'avail_qty' => $product->avail_qty,
                'featured' => $product->featured,
                'discounted' => $product->discounted,
                'duration' => $product->duration,
                'percentage' => $product->percentage,
                'images' => $images,
                'colors' => $colors,
                'sizes' => $sizes,
            ];

        })->all();

        return $products;
    }
}
