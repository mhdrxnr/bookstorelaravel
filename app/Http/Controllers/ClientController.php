<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function update(UpdateClientRequest $request, $id)
    {
        $Client = Client::findOrFail($id);
        $Client->update($request->validated());

         return response()->json($Client, 201);
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
