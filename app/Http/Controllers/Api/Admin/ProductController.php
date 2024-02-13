<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\AddProdSizeRequest;
use App\Http\Requests\AddProdColorRequest;
use App\Http\Requests\AddProdImageRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $prodService)
    {
    }

    public function addProduct(AddProductRequest $request): JsonResponse
    {
        $response = $this->prodService->addProduct($request->validated());

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to add product',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully',
        ], 200);
    }

    public function getAnyProduct(int $id): ProductResource
    {
        $product = $this->prodService->fetchProductById($id);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown product'
            ], 404);
        }

        return new ProductResource($product);
    }

    public function updateUproduct(int $id, UpdateProductRequest $request): JsonResponse
    {
        $response = $this->prodService->updateProductDetails($id, $request);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown product'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
        ], 200);
    }

    public function rmvProductImage(int $img_id): JsonResponse
    {
        $response = $this->prodService->removeProductImg($img_id);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product or File does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product image successfully removed',
        ], 200);
    }

    public function addProductImage(int $id, AddProdImageRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductImg($id, $request->other_images);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product image successfully added',
        ], 200);
    }

    public function addProductColor(int $id, AddProdColorRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductColor($id, $request->colors);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product color successfully added',
        ], 200);
    }

    public function rmvProductColor(int $color_id)
    {
        $response = $this->prodService->removeProductColor($color_id);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product color successfully removed',
        ], 200);
    }

    public function addProductSize(int $id, AddProdSizeRequest $request)
    {
        $response = $this->prodService->addProductSize($id, $request->sizes);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product size successfully added',
        ], 200);
    }

    public function rmvProductSize(int $size_id)
    {
        $response = $this->prodService->removeProductSize($size_id);

        if (! $response) {
            return response()->json([
                'success' => false,
                'message' => 'Product does not exist'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product size successfully removed',
        ], 200);
    }
}