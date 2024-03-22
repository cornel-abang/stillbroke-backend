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
        
        $extras = $this->extras->map(function ($extra) {
            $data = [];

            $data['id'] = $extra->id;
            $data['name'] = $extra->name;
            $data['value'] = $extra->value;

            return $data;
        })->groupBy('name')->toArray();
        
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
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
            'extras' => $extras
        ];
    }
}
