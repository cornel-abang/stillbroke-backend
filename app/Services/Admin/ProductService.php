<?php

namespace App\Services\Admin;

use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Jobs\UploadProductImgJob;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\UpdateProductCatRequest;
use App\Services\ProductService as AppProductService;

class ProductService extends AppProductService
{
    public function addProduct(array $details): void
    {
        $product = Product::create($details);
        
        dispatch(new UploadProductImgJob([
            'product_id' => $product->id, 
            'other_images' => $details['other_images'] ?? null,
            'colors' => $details['colors'] ?? null,
            'sizes' => $details['sizes'] ?? null,
        ]));
    }
    
    public function updateProductDetails(int $id, UpdateProductRequest $request): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        $product->update($request->validated());

        dispatch(new UploadProductImgJob([
            'product_id' => $product->id, 
            'other_images' => $request->other_images ?? null,
            'colors' => $request->colors ?? null,
            'sizes' => $request->sizes ?? null,
        ]));

        return true;
    }

    public function fetchAllProducts(): Collection
    {
        return Product::all();
    }

    public function removeProductImg($img_id): bool
    {
        $image = ProductImage::find($img_id);

        if (! $image) {
            return false;
        }
        
        return $image->delete();
    }

    public function addProductImg(int $id, array $other_images): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        foreach ($other_images as $image) {
            ProductImage::create([
                'product_id' => $id,
                'url' => $image
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
    
    public function addProductCategory(array $details): bool
    {
        Category::create([
            'name' => $details['name'],
            'image' => $details['image'],
        ]);

        return true;
    }

    public function updateProductCategory(int $id, UpdateProductCatRequest $request)
    {
        $category = Category::find($id);

        if (! $category) {
            return false;
        }

        $category->update($request->validated());

        return true;
    }

    public function deleteProductCategory(int $id): bool
    {
        $category = Category::find($id);

        if (! $category) {
            return false;
        }

        $category->delete();
        
        return true;
    }

    public function deleteProduct(int $id): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        $product->delete();
        
        return true;
    }

    public function getProductCategory(int $id): ?Category
    {
        return Category::find($id);
    }

    public function featureProduct(array $data): bool
    {
        $product = Product::find($data['id']);

        if (! $product) {
            return false;
        }

        return $product->makeFeatured();
    }

    public function unfeatureProduct(int $id): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        return $product->makeUnfeatured();
    }

    public function getFeaturedProducts(): Collection
    {
        return Product::where('featured', true)->get();
    }

    public function addDiscount(array $info): bool
    {
        $product = Product::find($info['product_id']);

        if (! $product) {
            return false;
        }

        $product->discount($info['percentage'], $info['duration']);

        return true;
    }

    public function setFeaturedTxt(string $featured_txt): string
    {
        $company = Company::first();
        $company->featured_txt = $featured_txt;
        $company->save();

        return $company->featured_txt;
    }

    public function getFeaturedTxt(): ?string
    {
        return Company::first()?->featured_txt;
    }

    public function getDiscount(int $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        return $product->getDiscount();
    }

    public function updateDiscount(array $details): bool
    {
        $product = Product::find($details['id']);

        if (! $product) {
            return false;
        }
        
        return $product->updateDiscount($details);
    }

    public function rmvProductDiscount(int $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        return $product->removeDiscount();
    }
}