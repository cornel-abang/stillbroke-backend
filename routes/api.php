<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;

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
    Route::post('forgot-password', [AuthController::class, 'startPasswordReset']);
    Route::post('password/update', [AuthController::class, 'completePasswordReset']);

    Route::group([
        'middleware' => 'auth',
    ], function () {
        Route::post('profile/{user_id}/update', [AuthController::class, 'updateClientProfile']);
        Route::get('current-user', [AuthController::class, 'getCurrentUser']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});

Route::group([
    'middleware' => 'auth',
], function () {
    /**
     * Product Endpoints
    */
    Route::get('products/category/{category_id}', [ProductController::class, 'getProductsByCategory']);
    Route::get('product/{id}', [ProductController::class, 'getProductById']);
    Route::post('products/{category_id}/filter', [ProductController::class, 'filterProducts']);
    Route::get('products/search', [ProductController::class, 'searchProducts']);
    Route::post('product/{id}/save', [ProductController::class, 'saveProduct']);
    Route::get('products/saved', [ProductController::class, 'getSavedProducts']);
});

/**
 * Cart Endpoints
 */
Route::group([
    'prefix' => 'cart',
], function () {
    Route::post('add-item', [CartController::class, 'addItemToCart']);
    Route::post('remove-item', [CartController::class, 'rmvItemFromCart']);
    Route::get('all-items', [CartController::class, 'getAllCartItems']);
});
