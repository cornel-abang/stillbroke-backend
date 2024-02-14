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

            $colors = $product->colors->map(function ($color) {
                return $color->color_code;
            });

            $sizes = $product->sizes->map(function ($size) {
                return $size->size_code;
            });

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'primary_image' => $product->primary_image,
                'gender' => $product->gender,
                'description' => $product->description,
                'featured' => $this->featured,
                'images' => $images,
                'colors' => $colors,
                'sizes' => $sizes,
            ];

        })->all();

        return $products;
    }
}
