<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductListingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function (Request $request) {
    return response()->json(['message' => 'Hello from Laravel']);
});

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/orders', [OrderController::class, 'store']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('categories/{categoryId}/products', [ProductListingController::class, 'byCategory']);
Route::get('categories/{categoryId}/groups/{groupId}/products',[ProductListingController::class,'byGroup']);
Route::get('categories/{categoryId}/groups/{groupId}/subgroups/{subgroupId}/products',[ProductListingController::class,'bySubgroup']);

