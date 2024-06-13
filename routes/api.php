<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthenticationController::class, 'authenticate']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/refresh',  [AuthenticationController::class, 'refresh']);


Route::group(['prefix' => 'product'], function () {
    Route::get('/getProductByCategory', [ProductController::class, 'getProductByCategory']);
    Route::get('/getProductById/{product}', [ProductController::class, 'getProductById']);
});
Route::group(['middleware' => ['jwt.verify']], function () {

    Route::group(['prefix' => 'order'], function () {
        Route::post('/createOrder', [OrderController::class, 'createOrder']);
    });
    Route::group(['prefix' => 'transaction'], function () {
        Route::post('/createTransaction', [TransactionController::class, 'createTransaction']);
        Route::get('/getTransactions', [TransactionController::class, 'getTransactions']);
        Route::get('/getTransactionById/{transactionId}', [TransactionController::class, 'getTransactionById']);
    });
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/getUser', [AuthenticationController::class, 'get_user']);
    Route::get('/protected', [AuthenticationController::class, 'protected']);
});

Route::group(['prefix' => 'cashier'], function () {
    Route::group(['middleware' => ['jwt.verify', 'auth.cashier']], function () {
        // Route::get('/getOrderById/{id}', [CashierController::class, 'getOrderById']);
        Route::get('/getTodaysOrder', [CashierController::class, 'getOrders']);
        Route::get('/orderReady/{order}', [CashierController::class, 'readyToPickUpOrder']);
        Route::post('/logout', [CashierController::class, 'logout']);
    });
    Route::post('/login', [CashierController::class, 'login']);
});

Route::post('/transactionNotification', [TransactionController::class, 'transactionNotification']);
Route::get('getStatus/{id}', [OrderController::class, 'getStatus']);
