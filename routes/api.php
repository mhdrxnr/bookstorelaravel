<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\{
    BookController, CategoryController, UserController, ClientController,
    OrderController, OrderDetailController, AdminController
};

// Public Routes
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/users', [UserController::class, 'store']); // Registration



    Route::get('/allOrders', [OrderController::class, 'allOrders']);
    Route::get('orders/{orderID}/client', [OrderController::class, 'getOrderClient']);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('books', BookController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('clients', ClientController::class);

    Route::get('books/favorites', [BookController::class, 'getFavoriteBooks']);
    Route::post('books/{book}/favorite', [BookController::class, 'addFavoriteBook']);
    Route::delete('books/{book}/favorite', [BookController::class, 'deleteFavoriteBook']);
    Route::get('/admin/stats', [AdminController::class, 'getStats']);
// Authenticated + Verified User Routes
Route::middleware(['auth:sanctum', 'checkUser'])->group(function () {
    Route::get('clients/{clientID}/orders', [ClientController::class, 'getClientOrders']);
    
    Route::get('/user', function (Request $request) {

        $user = $request->user();
        if (!$user) {
            Log::warning('User not authenticated!');
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return $user->load('client');
    });


    Route::get('/me', [UserController::class, 'me']);

    // Admin Dashboard route example
    Route::get('/admin/dashboard', fn(Request $request) => $request->user());
});

