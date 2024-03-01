<?php

namespace App\Jobs;

use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UploadProductImgJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected array $data)
    {
    }

    public function handle(): void
    {
        if (null !== $this->data['other_images']) {
            $this->saveImages();
        }

        if (null !== $this->data['colors']) {
            $this->saveColors();
        }

        if (null !== $this->data['sizes']) {
            $this->saveSizes();
        }
    }

    private function saveImages(): void
    {
        foreach ($this->data['other_images'] as $image) {
            
            ProductImage::create([
                'product_id' => $this->data['product_id'],
                'url' => $image
            ]);
        }
    }

    private function saveColors(): void
    {
        foreach ($this->data['colors'] as $color) {
            
            ProductColor::create([
                'product_id' => $this->data['product_id'],
                'color_code' => $color
            ]);
        }
    }

    private function saveSizes(): void
    {
        foreach ($this->data['sizes'] as $size) {
            
            ProductSize::create([
                'product_id' => $this->data['product_id'],
                'size_code' => $size
            ]);
        }
    }
}
