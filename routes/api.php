<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OrderController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/getToken', [AuthenticationController::class,'authenticate']);
Route::post('/register',[AuthenticationController::class,'register']);

Route::group(['middleware'=>['jwt.verify']], function(){
    Route::post('/getUser',[AuthenticationController::class,'get_user']);
    Route::get('/protected',[AuthenticationController::class,'protected']);
    
});

Route::resource('order', OrderController::class);
Route::post('test', [OrderController::class,'test']);
Route::get('getStatus/{id}',[OrderController::class,'getStatus']);