<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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

Route::post('/register', [AuthController::class, 'register']);

// User Login
Route::post('login', [AuthController::class, 'login']);

// Seller - Add Product
Route::middleware('auth:sanctum')->post('product', [ProductController::class, 'addProduct']);

// Admin - Approve Product
Route::middleware('auth:sanctum')->post('product/approve', [ProductController::class, 'approveProduct']);

// Client - Place Order
Route::middleware('auth:sanctum')->post('order', [OrderController::class, 'placeOrder']);

// Seller - Deliver Order
Route::middleware('auth:sanctum')->post('order/deliver', [OrderController::class, 'deliverOrder']);

