<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    ProductController,
    WarehouseController,
    TransactionController,
    StockController,
    UserController,
};

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth_api')->group(function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('warehouses', WarehouseController::class);
    Route::prefix('transactions')->group(function () {
        Route::post('/', [TransactionController::class, 'createTransaction']);
        Route::get('/', [TransactionController::class, 'index']);
    });
    Route::get('/stocks', [StockController::class, 'index']);
    Route::get('/users', [UserController::class, 'index']);
});