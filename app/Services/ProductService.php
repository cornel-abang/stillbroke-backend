<?php

namespace App\Services;

use App\Models\Extra;
use App\Models\Product;
use App\Models\Category;
use App\Models\SavedProduct;
use App\Events\ProductExtraRemoved;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Admin\ProductService as AdminProductService;

class ProductService
{
    public function fetchCategories(): ?Collection
    {
        return Category::all();
    }

    public function fetchProductsByCat(int $cat_id): Collection | bool
    {
        if (! $prodCategory = Category::find($cat_id)) {
            return false;
        }

        return $prodCategory->products;
    }

    public function fetchProductById(int $id): Product | bool
    {
        if (! $product = Product::find($id)) {
            return false;
        }

        return $product;
    }

    public function findByFilter(array $filterData): Collection | bool
    {
        $prodCategory = Category::find($filterData['category_id']);

        if (! $prodCategory) {
            return false;
        }

        $products = $prodCategory->products()
            ->where($filterData['type'], $filterData['filter'])
            ->get();
        
        return $products;
    }

    public function searchProducts(string $query): ?Collection
    {
        return Product::search($query)->get();
    }

    public function saveProduct(int $id): ?bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        if ($this->prodAlreadySaved($id)) {
            return null;
        }

        SavedProduct::create([
            'product_id' => $id,
            'user_id' => auth()->user()->id
        ]);

        return true;
    }

    public function fetchSavedProducts(): ?Collection
    {
        return auth()->user()->savedProducts;
    }

    public function fetchFeaturedProducts(): Collection
    {
        return Product::where('featured', true)->get();
    }

    public function fetchDetails(int $id): array | bool
    {
        $product = Product::find($id);

        if (! $product) {
            return false;
        }

        $details = [];
        $details['avail_qty'] = $product->avail_qty;
        $details['extras'] = $product->extras->map(function ($extra) {
            $data = [];

            $data['id'] = $extra->id;
            $data['name'] = $extra->name;
            $data['value'] = $extra->value;

            return $data;
        })->groupBy('name')->toArray();

        return $details;
    }

    public function deleteSaved(int $id): bool
    {
        $savedProduct = SavedProduct::where('product_id', $id);

        if (! $savedProduct) {
            return false;
        }

        return $savedProduct->delete();
    }

    public function prodAlreadySaved(int $id): bool
    {
        return SavedProduct::where('product_id', $id)
            ->where('user_id', auth()->user()->id)
            ->exists();
    }

    public function removeExtra(array $data): bool
    {
        $extra = Extra::find($data['extra_id']);

        if (! $extra) {
            return false;
        }

        event(new ProductExtraRemoved($data));

        return true;
    }
}
