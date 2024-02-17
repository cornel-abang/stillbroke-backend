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
use App\Http\Requests\AddProductCatRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\AddProdDiscountRequest;
use App\Http\Requests\UpdateProductCatRequest;
use App\Http\Requests\UpdateProdDiscountRequest;

class ProductController extends Controller
{
    public function __construct(private ProductService $prodService)
    {
    }

    public function addProduct(AddProductRequest $request): JsonResponse
    {
        $this->prodService->addProduct($request->validated());

        return $this->response(true, 'Product added successfully', 200);
    }

    public function getAnyProduct(int $id): ProductResource
    {
        $product = $this->prodService->fetchProductById($id);

        if (! $product) {
            return $this->response(false, 'Unknown product', 404);
        }

        return new ProductResource($product);
    }

    public function updateUproduct(int $id, UpdateProductRequest $request): JsonResponse
    {
        $response = $this->prodService->updateProductDetails($id, $request);

        if (! $response) {
            return $this->response(false, 'Unknown product', 404);
        }

        return $this->response(true, 'Product updated successfully', 200);
    }

    public function rmvProductImage(int $img_id): JsonResponse
    {
        $response = $this->prodService->removeProductImg($img_id);

        if (! $response) {
            return $this->response(false, 'Product or File does not exist', 404);
        }

        return $this->response(true, 'Product image successfully removed', 200);
    }

    public function addProductImage(int $id, AddProdImageRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductImg($id, $request->other_images);

        if (! $response) {
            return $this->response(false, 'Product does not exist', 404);
        }

        return $this->response(true, 'Product image successfully added', 200);
    }

    public function addProductColor(int $id, AddProdColorRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductColor($id, $request->colors);

        if (! $response) {
            return $this->response(false, 'Product does not exist', 404);
        }

        return $this->response(true, 'Product color successfully added', 200);
    }

    public function rmvProductColor(int $color_id): JsonResponse
    {
        $response = $this->prodService->removeProductColor($color_id);

        if (! $response) {
            return $this->response(false, 'Product does not exist', 404);
        }

        return $this->response(true, 'Product color successfully removed', 200);
    }

    public function addProductSize(int $id, AddProdSizeRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductSize($id, $request->sizes);

        if (! $response) {
            return $this->response(false, 'Product not found', 404);
        }

        return $this->response(true, 'Product size successfully added', 200);
    }

    public function rmvProductSize(int $size_id): JsonResponse
    {
        $response = $this->prodService->removeProductSize($size_id);

        if (! $response) {
            return $this->response(false, 'Product does not exist', 404);
        }

        return $this->response(true, 'Product size successfully removed', 200);
    }

    public function addProductCategory(AddProductCatRequest $request): JsonResponse
    {
        $response = $this->prodService->addProductCategory($request->validated());

        if (! $response) {
            return $this->response(false, 'Oops...Unable to upload category image', 500);
        }

        return $this->response(true, 'Product category successfully added', 200);
    }

    public function updateProductCategory(int  $id, UpdateProductCatRequest $request): JsonResponse
    {
        $response = $this->prodService->updateProductCategory($id, $request);

        if (! $response) {
            return $this->response(false, 'Category not found', 404);
        }

        return $this->response(true, 'Product category successfully updated', 200);
    }

    public function getProductCategories(): JsonResponse
    {
        $categories = $this->prodService->fetchCategories();
        $message = 'Categories found: '.$categories->count();

        return $this->response(
            true, $message, 
            200, ['categories' => $categories]
        );
    }

    public function deleteProductCategory(int $id): JsonResponse
    {
        $response = $this->prodService->deleteProductCategory($id);

        if (! $response) {
            return $this->response(false, 'Category not found', 404);
        }

        return $this->response(true, 'Product category successfully deleted', 200);
    }

    public function deleteProduct(int $id): JsonResponse
    {
        $response = $this->prodService->deleteProduct($id);

        if (! $response) {
            return $this->response(false, 'Product not found', 404);
        }

        return $this->response(true, 'Product successfully deleted', 200);
    }

    public function makeProductFeatured(int $id): JsonResponse
    {
        $response = $this->prodService->featureProduct($id);

        if (! $response) {
            return $this->response(false, 'Unable to feature product or not found', 404);
        }

        return $this->response(true, 'Product successfully featured', 200);
    }

    public function unfeatureProduct(int $id): JsonResponse
    {
        $response = $this->prodService->unfeatureProduct($id);

        if (! $response) {
            return $this->response(false, 'Unable to feature product or not found', 404);
        }

        return $this->response(true, 'Product successfully featured', 200);
    }

    public function getFeaturedProducts(): JsonResponse
    {
        $featuredProds = $this->prodService->getFeaturedProducts();

        return $this->response(
            true, 'Featured products found', 200, 
            ['featured_products' => $featuredProds]
        );
    }

    public function addProductDiscount(int $id, AddProdDiscountRequest $request): JsonResponse
    {
        $response = $this->prodService->addDiscount(
            array_merge($request->validated(), ['product_id' => $id])
        );

        if (! $response) {
            return $this->response(false, 'Product not found', 404);
        }

        return $this->response(true, 'Product discount successfully added', 200);
    }

    public function updateProductDiscount(UpdateProdDiscountRequest $request, int $id): JsonResponse
    {
        $response = $this->prodService->updateDiscount(array_merge(
            $request->validated(), ['id' => $id], ['discounted' => true]
        ));

        if (! $response) {
            return $this->response(false, 'Product not found', 404);
        }

        return $this->response(true, 'Product discount successfully updated', 200);
    }

    public function removeProductDiscount(int $id): JsonResponse
    {
        $response = $this->prodService->rmvProductDiscount($id);

        if (! $response) {
            return $this->response(false, 'Product not found', 404);
        }

        return $this->response(true, 'Product discount successfully removed', 200);
    }

    private function response(
        bool $success, string $message, 
        string $status_code, $data = []
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }
}