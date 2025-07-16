<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductListingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\DeliveryAddressController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/address', [AddressController::class, 'show']);              // Get invoice address
    Route::put('/address', [AddressController::class, 'update']);            // Update invoice address

    // Delivery Addresses
    Route::get('/delivery-addresses', [DeliveryAddressController::class, 'index']);    // Get all delivery addresses
    Route::post('/delivery-addresses', [DeliveryAddressController::class, 'store']);   // Create new
    Route::put('/delivery-addresses/{id}', [DeliveryAddressController::class, 'update']); // Update
    Route::delete('/delivery-addresses/{id}', [DeliveryAddressController::class, 'destroy']); // Delete
});

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('categories/{categoryId}/products', [ProductListingController::class, 'byCategory']);
Route::get('categories/{categoryId}/groups/{groupId}/products',[ProductListingController::class,'byGroup']);
Route::get('categories/{categoryId}/groups/{groupId}/subgroups/{subgroupId}/products',[ProductListingController::class,'bySubgroup']);