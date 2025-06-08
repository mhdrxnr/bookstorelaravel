<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;




use function Pest\Laravel\json;

class UserController
{

    public function getClientUser($userID){
        $client = User::findOrFail($userID)->client;
        return response()->json($client, 200);
    }

 public function login(Request $request) {

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Incorrect password or email'], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_Token')->plainTextToken;

    return response()->json([
        'message' => 'Welcome again',
        'user' => $user, 
        'token' => $token 
    ], 200);
}

public function logout(Request $request)  {
    $request->user()->currentAccessToken()->delete();
    return response(['message'=>'you are out']);
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
            'email'=>'sometimes|email|unique:users,email',
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
