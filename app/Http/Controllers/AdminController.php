<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController
{
    public function getStats()
{
    return response()->json([
        'books' => \App\Models\Book::count(),
        'categories' => \App\Models\Category::count(),
        'orders' => \App\Models\Order::count(),
        'clients' => \App\Models\Client::count(),
    ]);
}
}
