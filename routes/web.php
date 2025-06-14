<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\{
    BookController, CategoryController, UserController, ClientController,
    OrderController, OrderDetailController
};
Route::get('/', function () {
    return view('welcome');
});





// Route::middleware('auth:sanctum')->post('/orders', [OrderController::class, 'store']);
