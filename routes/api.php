<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin/dashboard', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::post('login',[UserController::class,'login']);
Route::post('logout',[UserController::class,'logout'])->middleware('auth:sanctum');

Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::put('/users/{id}', [UserController::class, 'update']);


Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return $request->user();
});



Route::middleware('auth:sanctum')->group(function(){
Route::get('ordersall',[OrderController::class,'allOrders'])->middleware('checkUser');
Route::apiResource('users', UserController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('orderDetails', OrderDetailController::class);

Route::prefix('books')->group(function(){
//to add a book to an order by book id 
Route::post('/{bookID}/orders',[BookController::class,'addBookToOrder']);
//to get an order of a book by book id
Route::get('/{bookID}/orders',[BookController::class,'getOrderBook']);
});

Route::prefix('clients')->group(function(){
Route::get('clients/{clientID}/orders',[ClientController::class,'getClientOrder']);
Route::get('clients/{orderID}/orders',[OrderController::class,'getOrderClient']);
   });


});
Route::post('/users', [UserController::class, 'store']);