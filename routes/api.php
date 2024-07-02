<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Cashier\CashierController;
use App\Http\Controllers\Cashier\IncomeController;
use App\Http\Controllers\Cashier\ProductManagementController;
use App\Http\Controllers\Cashier\StoreController;
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

Route::group(['prefix' => 'store'], function () {
    Route::get('getOpenCloseHour', [StoreController::class, 'getOpenCloseHour']);
    Route::post('setOpenCloseHour/{id}', [StoreController::class, 'setOpenCloseHour']);
});

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::group(['prefix' => 'order'], function () {
        Route::post('/createOrder', [OrderController::class, 'createOrder']);
    });
    Route::group(['prefix' => 'transaction'], function () {
        Route::post('/redeemPoint', [TransactionController::class, 'createRedeemPointTransaction']);
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
        Route::get('/getOrderById/{id}', [CashierController::class, 'getOrderById']);
        Route::get('/getTodaysOrder', [CashierController::class, 'getOrders']);
        Route::post('/confirmOrder/{order}', [CashierController::class, 'confirmOrder']);
        Route::get('/orderReady/{order}', [CashierController::class, 'readyToPickUpOrder']);
        Route::get('/collectOrder/{order}', [CashierController::class, 'finishOrder']);
        Route::post('/logout', [CashierController::class, 'logout']);

        Route::group(['prefix' => 'product'], function () {
            Route::get('getCategories', [ProductManagementController::class, 'getCategories']);
            Route::get('getProduct/{id}', [ProductManagementController::class, 'getProduct']);
            Route::get('getAllProduct', [ProductManagementController::class, 'getAllProduct']);
            Route::post('createProduct', [ProductManagementController::class, 'createProduct']);
            Route::put('updateProduct/{id}', [ProductManagementController::class, 'updateProduct']);
            Route::delete('deleteProduct/{id}', [ProductManagementController::class, 'deleteProduct']);
        });

        Route::group(['prefix' => 'income'], function () {
            Route::get('getIncome', [IncomeController::class, 'getIncome']);
        });
    });
    Route::post('/login', [CashierController::class, 'login']);
});

Route::post('/transactionNotification', [TransactionController::class, 'transactionNotification']);
Route::get('getStatus/{id}', [OrderController::class, 'getStatus']);
