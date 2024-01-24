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

        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'color' => $this->color,
            'description' => $this->description,
            'images' => $images,
        ];
    }
}
