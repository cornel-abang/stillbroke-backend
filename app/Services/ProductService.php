<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use App\Models\SavedProduct;
use Illuminate\Database\Eloquent\Collection;

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
}
