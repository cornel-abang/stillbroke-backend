<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = $this->images->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => $image->url
            ];
        });

        $colors = $this->colors->map(function ($color) {
            return [
                'id' => $color->id,
                'code' => $color->color_code
            ];
        });

        $sizes = $this->sizes->map(function ($size) {
            return [
                'id' => $size->id,
                'code' => $size->size_code
            ];
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'primary_image' => $this->primary_image,
            'gender' => $this->gender,
            'description' => $this->description,
            'avail_qty' => $this->avail_qty,
            'featured' => $this->featured,
            'discounted' => $this->discounted,
            'duration' => $this->duration,
            'percentage' => $this->percentage,
            'images' => $images,
            'colors' => $colors,
            'sizes' => $sizes,
        ];
    }
}
