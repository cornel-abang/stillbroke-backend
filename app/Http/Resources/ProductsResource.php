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

            $extras = $product->extras->map(function ($extra) {
                $data = [];
    
                $data['id'] = $extra->id;
                $data['name'] = $extra->name;
                $data['value'] = $extra->value;
    
                return $data;
            })->groupBy('name')->toArray();

            return [
                'id' => $product->id,
                'category_id' => $product->category_id,
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
                'extras' => $extras
            ];

        })->all();

        return $products;
    }
}
