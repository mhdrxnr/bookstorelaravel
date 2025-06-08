<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class OrderController
{

       public function getOrderClient($orderID){
        $order = Order::with('client')->findOrFail($orderID);

        return response()->json($order, 200);
    }

     public function allOrders()
    {
        $orders = Order::all();
        return response()->json($orders, 200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders=Auth::user()->orders;

        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {

        $user_id=Auth::user()->user_id;

        $validated=$request->validated();
        $validated['userID']=$user_id;

        $Order = Order::create($validated);

        return response()->json($Order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $Order = Order::findOrFail($id);
        $Order->all();

        return response()->json($Order, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $userID = Auth::user()->user_id;
        $Order = Order::findOrFail($id);

        if ($Order->userID != $userID)
        return response()->json(['message'=>'not authourized'], 403);
        

        $Order->update($request->validated());

        return response()->json($Order, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $Order = Order::findOrFail($id);
        $Order->delete();

        return response()->json($Order, 204);
    }
}
