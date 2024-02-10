<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Product;
use App\Jobs\UploadProductImgJob;
use Illuminate\Http\UploadedFile;

class ProductService
{
    public function addProduct(array $details): bool
    {
        $primary_image = self::uploadImageFile($details['primary_image']);

        if (! $primary_image) {
            return false;
        }

        $product = Product::create(
            array_merge(
                $details, 
                ['primary_image' => $primary_image]
            )
        );

        /**
         * Cannot dispatch *UploadedFile* type to the queue
         * Difficult to serialize.
         * We pass the img urls for dispatch instead
         */
        $other_images = collect($details['other_images'])
            ->map(function (UploadedFile $image) {
                return self::uploadImageFile($image);
            })->filter()
            ->all();
        
        dispatch(new UploadProductImgJob([
            'product_id' => $product->id, 
            'other_images' => $other_images,
            'colors' => $details['colors'],
            'sizes' => $details['sizes'],
        ]));

        return true;
    }
    
    public static function uploadImageFile(UploadedFile $image): string | bool 
    {
        try {
            $imgName = time() . '.' . $image->extension();
            $image->move(public_path('images/products'), $imgName);
            $imgUrl = url('/images/products') . '/'. $imgName;

            return $imgUrl;

        } catch (Exception) {

            return false;
        }
    }
}