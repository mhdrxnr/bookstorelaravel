<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController
{

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
        $Book = Book::all();

        return response()->json($Book, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
       $data = $request->validated();

    

    $book = Book::create($data);

    return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $Book = Book::findOrFail($id);
        $Book->all();

        return response()->json($Book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $Book = Book::findOrFail($id);
        $Book->update($request->validated());
// Handle image upload
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('books', 'public');
    }
        return response()->json($Book, 201);
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
