<?php

namespace App\Services\Admin;

use App\Models\Extra;
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

        if (null !== $details['other_images']) {
            $this->saveImages($details['other_images'], $product->id);
        }

        if (null !== $details['extras']) {
            $this->saveExtras($details['extras'], $product->id);
        }
        
        // dispatch(new UploadProductImgJob([
        //     'product_id' => $product->id, 
        //     'other_images' => $details['other_images'] ?? null,
        //     'extras' => $details['extras'] ?? null,
        // ]));
    }
    
    public function updateProductDetails(int $id, UpdateProductRequest $request): bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        $product->update($request->validated());

        if (null !== $request->other_images) {
            $this->saveImages($request->other_images, $product->id);
        }

        if (null !== $request->extras) {
            $this->saveExtras($request->extras, $product->id);
        }

        return true;
    }

    public function fetchAllProducts(): Collection
    {
        return Product::all();
    }

    public function removeProductExtra($id): bool
    {
        $extra = Extra::find($id);

        if (! $extra) {
            return false;
        }
        
        return $extra->delete();
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

    private function saveImages(array $other_images, int $product_id): void
    {
        foreach ($other_images as $image) {
            
            ProductImage::create([
                'product_id' => $product_id,
                'url' => $image
            ]);
        }
    }

    private function saveExtras(array $extras, int $product_id): void
    {
        foreach ($extras as $extra) {
            foreach ($extra as $name => $value) {
                Extra::create([
                    'product_id' => $product_id,
                    'name' => $name,
                    'value' => $value
                ]);
            }
        }
    }
}