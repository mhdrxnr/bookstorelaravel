<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Pest\Laravel\json;

class OrderController
{

     public function getOrderClient($orderID)
{
    $order = Order::findOrFail($orderID);
    $client = $order->user->client; // Assuming you have these relations set up

    if (!$client) {
        return response()->json(['message' => 'Client not found'], 404);
    }

    return response()->json([
        'firstName' => $client->firstName,
        'lastName' => $client->lastName,
        'number' => $client->number,
        'address' => $client->address,
        'wilaya' => $client->wilaya,
    ]);
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
    $validated = $request->validated();

    // Ensure 'user_id' is present (already validated in StoreOrderRequest)
    $userID = $validated['user_id'];

    // Map 'user_id' to 'userID' if your model uses camelCase
    $validated['userID'] = $userID;
    unset($validated['user_id']);

    $bookItems = $request->input('books');

    DB::beginTransaction();

    try {
        // Create the order with userID
        $order = Order::create($validated);

        // Insert book items into order_details
        foreach ($bookItems as $item) {
            DB::table('order_details')->insert([
                'orderID' => $order->order_id,
                'bookID' => $item['bookID'],
                'quantity' => $item['quantity'],
                'unitPrice' => $item['unitPrice'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Order placed successfully.',
            'order' => $order,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Order failed.',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    /**
     * Display the specified resource.
     */
public function show($id)
{
    $order = Order::with(['books' => function ($query) {
        $query->withPivot('quantity', 'unitPrice');
    }])->findOrFail($id);

    return response()->json($order, 200);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $id)
{
    $order = Order::findOrFail($id);

    $order->update($request->validated());

    return response()->json($order, 200);
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
