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
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;


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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/address', [AddressController::class, 'show']);              // Get invoice address
    Route::put('/user/address', [AddressController::class, 'update']);            // Update invoice address
    Route::get('/user/delivery-addresses', [DeliveryAddressController::class, 'index']);    // Get all delivery addresses
    Route::post('/user/delivery-addresses', [DeliveryAddressController::class, 'store']);   // Create new
    Route::put('/user/delivery-addresses/{id}', [DeliveryAddressController::class, 'update']); // Update
    Route::delete('/user/delivery-addresses/{id}', [DeliveryAddressController::class, 'destroy']); // Delete
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::post('/user/change-password', [UserController::class, 'changePassword']);
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::put('/cart/{id}', [CartController::class, 'update']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);
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