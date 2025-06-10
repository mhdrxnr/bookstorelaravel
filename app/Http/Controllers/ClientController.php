<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class ClientController
{

     public function getClientOrder($clientID){
        $client = Client::with('orders')->findOrFail($clientID);

        return response()->json($client, 200);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Client = Client::all();

        return response()->json($Client, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $Client = Client::create($request->validated());
       
        return response()->json($Client, 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $Client = Client::where('userID',$id)->firstOrFail();
        $Client->all();
        return response()->json($Client, 200);
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, $id)
{
    $client = Client::findOrFail($id);

    $validated = $request->validate([
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'number' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'wilaya' => 'required|string|max:100',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('clients', 'public');
        $validated['image'] = asset('storage/' . $imagePath);
    }

    $client->update($validated);

    return response()->json(['message' => 'Client updated successfully', 'client' => $client]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $Client = Client::findOrFail($id);
        $Client->delete();

        return response()->json($Client, 204);
    }
}
