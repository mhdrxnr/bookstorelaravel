<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class BookController
{
   public function addFavoriteBook(Request $request, $book_id)
{
    $userID = $request->input('user_id');

    if (!$userID) {
        return response()->json(['message' => 'User ID is required'], 400);
    }

    $book = Book::findOrFail($book_id);

    $user = User::where('user_id', $userID)->firstOrFail();

    if (!$user->favoriteBooks()->where('book_id', $book_id)->exists()) {
        $user->favoriteBooks()->attach($book_id);
    }

    return response()->json(['message' => 'Book added to favorites']);
}


public function deleteFavoriteBook(Request $request, $book_id)
{
    $userID = $request->input('user_id');

    if (!$userID) {
        return response()->json(['message' => 'User ID is required'], 400);
    }

    $user = User::where('user_id', $userID)->firstOrFail();

    $user->favoriteBooks()->detach($book_id);

    return response()->json(['message' => 'Book removed from favorites']);
}



public function getFavoriteBooks(Request $request)
{
    $userID = $request->input('user_id');

    if (!$userID) {
        return response()->json(['message' => 'User ID is required'], 400);
    }

    $user = User::where('user_id', $userID)->firstOrFail();

    $favorites = $user->favoriteBooks()->with('category')->get();

    return response()->json($favorites);
}







    public function addBookToOrder(Request $request, $bookID) {
        $book = Book::findOrFail($bookID);
        $book->orders()->attach($request->orderID, [
        'quantity' => $request->quantity,
        'unitPrice' => $request->unitPrice,
    ]
    );
        return  response()->json('seccuss',200);
    }

    public function getOrderBook($bookID){
        $orders = Book::findOrFail($bookID)->orders;
        return response()->json($orders, 200);
    }

    



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Book = Book::with('category')->get();

        return response()->json($Book, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('books', 'public');
    }

    $book = Book::create($data);

    return response()->json($book, 201);
}
    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $Book = Book::findOrFail($id);

        return response()->json($Book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateBookRequest $request, $id)
{
    $Book = Book::findOrFail($id);
    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('books', 'public');
    }

    $Book->update($data);

    return response()->json($Book->load('category'), 200);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $Book = Book::findOrFail($id);
        $Book->delete();

        return response()->json($Book, 204);
    }
}
