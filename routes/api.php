<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify', [AuthController::class, 'verify']);
    Route::post('forgot-password', [AuthController::class, 'startForgotPasswordReset']);
    Route::post('password/update', [AuthController::class, 'completeForgotPasswordReset']);

    Route::group([
        'middleware' => 'auth',
    ], function () {
        Route::post('profile/{user_id}/update', [AuthController::class, 'updateClientProfile']);
        Route::post('/{user_id}/reset-password', [AuthController::class, 'resetUserPassword']);
        Route::get('current-user', [AuthController::class, 'getCurrentUser']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

/**
 * Payment endpoints
 */
Route::group([
    'middleware' => 'auth',
    'prefix' => 'payment',
], function () {
    Route::post('pay', [PaymentController::class, 'processPayment']);
});

/**
 * Order endpoints
 */
Route::group([
    'middleware' => 'auth',
    'prefix' => 'order',
], function () {
    Route::get('user/{id}/all', [OrderController::class, 'getAllUserOrders']);
});

/**
 * Product Endpoints
 */
Route::get('product/categories', [ProductController::class, 'getAllProductCategories']);
Route::get('products/category/{category_id}', [ProductController::class, 'getProductsByCategory']);
Route::get('product/{id}', [ProductController::class, 'getProductById']);
Route::post('products/{category_id}/filter', [ProductController::class, 'filterProducts']);
Route::get('products/search', [ProductController::class, 'searchProducts']);
Route::group([
    'middleware' => 'auth',
], function () {
    Route::post('product/{id}/save', [ProductController::class, 'saveProduct']);
    Route::get('products/saved', [ProductController::class, 'getSavedProducts']);
    Route::delete('product/saved/{id}', [ProductController::class, 'deleteSavedProducts']);
});

/**
 * Cart Endpoints
 */
Route::group([
    'prefix' => 'cart',
], function () {
    Route::post('item/add', [CartController::class, 'addItemToCart']);
    Route::post('item/remove', [CartController::class, 'rmvItemFromCart']);
    Route::get('items/all', [CartController::class, 'getAllCartItems']);
    Route::post('item/update-qty', [CartController::class, 'updateCartItemQty']);
    Route::post('update', [CartController::class, 'updateCartData']);
});


/**
 * Admin - CMS Endpoints
 */
Route::group([
    'middleware' => 'admin.only',
    'prefix' => 'admin',
], function () {
    /**
     * User endpoints
     */
    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::post('/add', [UserController::class, 'addAdminUser']);
        Route::get('/{id}', [UserController::class, 'getAnyUser']);
        Route::post('/{id}/update', [UserController::class, 'updateUserDetails']);
        Route::get('/{id}/delete', [UserController::class, 'deleteUser']);
    });

    /**
     * Products endpoints
     */
    Route::group([
        'prefix' => 'product',
    ], function () {
        Route::post('add', [AdminProductController::class, 'addProduct']);
        Route::get('{id}', [AdminProductController::class, 'getAnyProduct']);
        Route::post('{id}/update', [AdminProductController::class, 'updateUproduct']);
        Route::delete('{id}/delete', [AdminProductController::class, 'deleteProduct']);
        /**
         * Product Extras - Image, Color & Size 
        */
        Route::post('{id}/image/add', [AdminProductController::class, 'addProductImage']);
        Route::get('image/{img_id}/remove', [AdminProductController::class, 'rmvProductImage']);
        Route::post('{id}/color/add', [AdminProductController::class, 'addProductColor']);
        Route::get('color/{color_id}/remove', [AdminProductController::class, 'rmvProductColor']);
        Route::post('{id}/size/add', [AdminProductController::class, 'addProductSize']);
        Route::get('size/{size_id}/remove', [AdminProductController::class, 'rmvProductSize']);
        /**
         * Product Category  
        */
        Route::post('category/add', [AdminProductController::class, 'addProductCategory']);
        Route::post('category/{id}/update', [AdminProductController::class, 'updateProductCategory']);
        Route::get('categories/all', [AdminProductController::class, 'getProductCategories']);
        Route::delete('category/{id}/delete', [AdminProductController::class, 'deleteProductCategory']);
        /**
         * Featured Product 
        */
        Route::post('{id}/feature', [AdminProductController::class, 'makeProductFeatured']);
        Route::get('{id}/unfeature', [AdminProductController::class, 'unfeatureProduct']);
        Route::get('featured/all', [AdminProductController::class, 'getFeaturedProducts']);
        /**
         * Discount endpoints
         */
        Route::group([
            'prefix' => '{id}/discount',
        ], function () {
            Route::post('add', [AdminProductController::class, 'addProductDiscount']);
            Route::post('update', [AdminProductController::class, 'updateProductDiscount']);
            Route::get('remove', [AdminProductController::class, 'removeProductDiscount']);
        });
    });

    /**
     * Order endpoints
     */
    Route::group([
        'prefix' => 'order',
    ], function () {
        Route::get('all', [AdminOrderController::class, 'getAllOrders']);
        // Route::get('{}', [AdminOrderController::class, 'getAllOrders']);
    });

    /**
     * Payment endpoints
     */
    Route::group([
        'prefix' => 'payment',
    ], function () {
        Route::get('all', [AdminPaymentController::class, 'getAllPayments']);
    });
});
