<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\{
    BookController, CategoryController, UserController, ClientController,
    OrderController, OrderDetailController
};

// Public Routes
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);
Route::post('/users', [UserController::class, 'store']); // Registration

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
    $user = $request->user();
    if (!$user) {
        Log::warning('User not authenticated!');
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
    return $user->load('client');
});


Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    $user = $request->user()->load(['client', 'favoriteBooks']);

    $client = $user->client;

    return response()->json([
        'user_id' => $user->user_id,
        'email' => $user->email,
        'role' => $user->role,
        'client' => $client ? [
            'client_id' => $client->client_id,
            'firstName' => $client->firstName,
            'lastName' => $client->lastName,
            'number' => $client->number,
            'address' => $client->address,
            'wilaya' => $client->wilaya,
            'imageUrl' => $client->image
        ] : null,
        'favoriteBooks' => $user->favoriteBooks
    ]);
});


// Authenticated User Info


// Admin Dashboard route example
Route::middleware('auth:sanctum')->get('/admin/dashboard', fn(Request $request) => $request->user());
 Route::apiResource('orderDetails', OrderDetailController::class);
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
// Route::post('/orders', [OrderController::class, 'store']);
// Authenticated + Verified User Routes
Route::middleware(['auth:sanctum', 'checkUser'])->group(function () {
    
   
    // Route::apiResource('orders', OrderController::class);
    // Route::post('/orders', [OrderController::class, 'store']);

    
    Route::get('clients/{clientID}/orders', [ClientController::class, 'getClientOrders']);

});

