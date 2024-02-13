<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Product;
use App\Jobs\UploadProductImgJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Services\ProductService as AppProductService;

class ProductService extends AppProductService
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

    public function updateProductDetails(int $id, UpdateProductRequest $request): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        $data = $request->validated();

        if ($request->hasFile('primary_image')) {
            $data['primary_image'] = self::uploadImageFile($request->primary_image);
            
            /**
             * Delete old primary image file from server
             */
            $old_img_path = public_path( parse_url($product->primary_image)['path'] );
            if(File::exists($old_img_path)) {
                File::delete($old_img_path);
            }
        }

        $product->update($data);

        return true;
    }

    public function removeProductImg($img_id): bool
    {
        $image = ProductImage::find($img_id);

        if (! $image) {
            return false;
        }

        $img_path = public_path( parse_url($image->url)['path'] );
        if(! File::exists($img_path)) {
            return false;
        }
        
        $image->delete();

        return File::delete($img_path);
    }

    public function addProductImg(int $id, array $other_images): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        foreach ($other_images as $image) {

            $image_url = self::uploadImageFile($image);
            ProductImage::create([
                'product_id' => $id,
                'url' => $image_url
            ]);
        }

        return true;
    }

    public function addProductColor(int $id, array $colors): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        foreach ($colors as $color) {
            ProductColor::create([
                'product_id' => $id,
                'color_code' => $color
            ]);
        }

        return true;
    }

    public function removeProductColor(int $color_id): bool
    {
        $color = ProductColor::find($color_id);

        if (! $color) {
            return false;
        }

        $color->delete();

        return true;
    }

    public function addProductSize(int $id, array $sizes)
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        foreach ($sizes as $size) {
            ProductSize::create([
                'product_id' => $id,
                'size_code' => $size
            ]);
        }

        return true;
    }

    public function removeProductSize(int $size_id): bool
    {
        $size = ProductSize::find($size_id);

        if (! $size) {
            return false;
        }

        $size->delete();

        return true;
    }
}