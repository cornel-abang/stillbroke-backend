<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = $this->images->map(function ($image) {
            return $image->url;
        });

        $colors = $this->colors->map(function ($color) {
            return $color->color_code;
        });

        $sizes = $this->sizes->map(function ($size) {
            return $size->size_code;
        });

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'primary_image' => $this->primary_image,
            'gender' => $this->gender,
            'description' => $this->description,
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
