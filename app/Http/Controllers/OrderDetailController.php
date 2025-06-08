<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Requests\OrderDetail\StoreOrderDetailRequest;
use App\Http\Requests\OrderDetail\UpdateOrderDetailRequest;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $OrderDetail = OrderDetail::all();

        // return response()->json($OrderDetail, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderDetailRequest $request)
    {
        // $OrderDetail = OrderDetail::create($request->validated());

        // return response()->json($OrderDetail, 2001);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $OrderDetail = OrderDetail::findOrFail($id);
        // $OrderDetail->all();

        // return response()->json($OrderDetail, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderDetailRequest $request, $id)
    {
        // $OrderDetail = OrderDetail::findOrFail($id);
        // $OrderDetail->update($request->validated());

        // return response()->json($OrderDetail, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        // $OrderDetail = OrderDetail::findOrFail($id);
        // $OrderDetail->delete();

        // return response()->json($OrderDetail, 204);
    }
}
