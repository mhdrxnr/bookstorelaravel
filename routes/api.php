<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\FavoriteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin/dashboard', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::put('/clients/{id}', [ClientController::class, 'update']);
Route::put('/users/{id}', [UserController::class, 'update']);


Route::get('/me', function (Request $request) {
    $user = $request->user();

    if (!$user) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    return $user->load('favoriteBooks');
})->middleware('auth:sanctum');




  
    
    
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('books', BookController::class);

 
 
Route::middleware('auth:sanctum','checkUser')->group(function () {
    Route::get('ordersall', [OrderController::class, 'allOrders']);
    Route::apiResource('users', UserController::class);
    Route::apiResource('clients', ClientController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('orderDetails', OrderDetailController::class);

    Route::get('books/favorites', [BookController::class, 'getFavoriteBooks']);
    Route::post('book/{book_id}/favorite', [BookController::class, 'addFavoriteBook']);
    Route::delete('book/{book_id}/favorite', [BookController::class, 'deleteFavoriteBook']);
    
   
   
   
    // Route::prefix('books')->group(function () {
    //     //to add a book to an order by book id 
    //     Route::post('/{bookID}/orders', [BookController::class, 'addBookToOrder']);
    //     //to get an order of a book by book id
    //     Route::get('/{bookID}/orders', [BookController::class, 'getOrderBook']);
    // });

    Route::prefix('clients')->group(function () {
        Route::get('clients/{clientID}/orders', [ClientController::class, 'getClientOrder']);
        Route::get('clients/{orderID}/orders', [OrderController::class, 'getOrderClient']);
    });
});

Route::post('users', [UserController::class, 'store']);
