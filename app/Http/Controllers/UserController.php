<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;



use function Pest\Laravel\json;

class UserController 
{
public function me(Request $request)
{
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
            'imageUrl' => $client->image,
        ] : null,
        'favoriteBooks' => $user->favoriteBooks,
    ]);
}

    public function getClientUser($userID)
{
    $client = User::findOrFail($userID)->client;
    return response()->json($client, 200);
}

 public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    Auth::login($user);

    $client = $user->client; // make sure relationship is defined

    return response()->json([
        'message' => 'Login successful',
        'user' => [
            'user_id' => $user->user_id,
            'email' => $user->email,
            'role' => $user->role
        ],
        'client' => $client ? [
            'client_id' => $client->client_id,
            'firstName' => $client->firstName,
            'lastName' => $client->lastName,
            'number' => $client->number,
            'address' => $client->address,
            'wilaya' => $client->wilaya,
            'imageUrl' =>  $client->image
        ] : null
    ]);
}


public function logout(Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response(['message' => 'Logged out']);
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $User = User::all();
        return response()->json($User,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

            $request->validate([
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|confirmed|min:8',
            'number'=>'required|numeric|unique:clients,number|min:10'
        ]);
        
         $user = User::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'client'
         ]);
         $client = Client::create([
            'number'=>$request->number,
            'userID'=>$user->user_id
         ]);
        return response()->json(['message'=>'registered seccuss',$user,$client],201);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
           $User = User::findOrFail($id);
           $User->all();

        return response()->json($User, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);
        $User->update($request->validate([
            'email' => 'nullable|email|unique:users,email,' . $id . ',user_id',
            'password'=>'nullable|string|min:8',
            'role'=>'sometimes|in:admin,client',
        ]));

        return response()->json($User, 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
          $User = User::findOrFail($id);
          $User->delete();

        return response()->json($User, 204);
    }
}
