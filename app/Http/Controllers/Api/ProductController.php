<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\RemoveExtraRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $prodService)
    {
    }

    public function getAllProductCategories(): JsonResponse
    {
        $categories = $this->prodService->fetchCategories();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ], 200);
    }

    public function getProductsByCategory(int $category_id): ProductsResource | JsonResponse
    {
        $products = $this->prodService->fetchProductsByCat($category_id);
        
        if (! $products) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid product category searched'
            ], 404);
        }

        return new ProductsResource($products);
    }

    public function getProductById(int $id): ProductResource | JsonResponse
    {
        $product = $this->prodService->fetchProductById($id);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown product searched'
            ], 404);
        }

        return new ProductResource($product);
    }

    public function filterProducts(int $category_id, FilterRequest $request): ProductsResource | JsonResponse
    {
        $filterData = [
            'category_id' => $category_id,
            'type' => $request->type,
            'filter' => $request->filter,
        ];

        $products = $this->prodService->findByFilter($filterData);

        if (! $products || $products->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found for filter criteria: '.$request->filter
            ], 404);
        }

        return new ProductsResource($products);
    }

    public function searchProducts(Request $request): ProductsResource | JsonResponse
    {
        $search = $request->search_string;

        if (! is_string($search) || $search === '') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search query provided'
            ], 400);
        }

        $response = $this->prodService->searchProducts($search);
        
        if ($response->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products found for search criteria: '.$search
            ], 404);
        }

        return new ProductsResource($response);
    }

    public function saveProduct(int $id): JsonResponse
    {
        $saved = $this->prodService->saveProduct($id);
        
        if (false === $saved) {
            return response()->json([
                'success' => false,
                'message' => 'Trying to save unknown item'
            ], 404);
        }

        if (null === $saved) {
            return response()->json([
                'success' => false,
                'message' => 'Product already saved'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item saved successfully'
        ], 201);
    }

    public function getSavedProducts(): ProductsResource | JsonResponse
    {
        $savedProducts = $this->prodService->fetchSavedProducts();
        
        if($savedProducts->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'You have no saved items yet'
            ], 200);
        }

        return new ProductsResource($savedProducts);
    }

    public function getFeaturedProducts()
    {
        $featuredProducts = $this->prodService->fetchFeaturedProducts();

        if($featuredProducts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No featured products',
                'featured' => []
            ], 200);
        }

        return new ProductsResource($featuredProducts);
    }

    public function getProductDetails(int $id)
    {
        $details = $this->prodService->fetchDetails($id);

        if (! $details) {
            return response()->json([
                'success' => false,
                'message' => 'Unkown product'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Details found',
            'data' => $details
        ], 200);
    }

    public function deleteSavedProducts($id)
    {
        $response = $this->prodService->deleteSaved($id);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Trying to unsave an unknown item'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item unsaved successfully'
        ], 201);
    }

    public function removeProductExtra(RemoveExtraRequest $request)
    {
        $response = $this->prodService->removeExtra($request->validated());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Unkown product extra'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Extra removed successfully'
        ], 201);
    }
}
