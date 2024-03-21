<?php

namespace App\Jobs;

use App\Models\Extra;
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

        if (null !== $this->data['extras']) {
            $this->saveExtras();
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

    private function saveExtras(): void
    {
        foreach ($this->data['extras'] as $name => $values) {
            foreach ($values as $value) {
                Extra::create([
                    'product_id' => $this->data['product_id'],
                    'name' => $name,
                    'value' => $value
                ]);
            }
        }
    }
}
