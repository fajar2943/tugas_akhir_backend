<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $this->validate($request, [
            'nama' => 'required|max:50', 
            'email' => 'required|max:50|email|unique:users', 
            'password' => 'required|max:50', 
            'fcm_token' => 'required|max:255', 
        ]);
        $request['name'] = $request->nama;
        $request['role'] = 'Customer';
        $request['status'] = 'Verify';
        $request['notif_token'] = uniqid();
        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;  
        return response()->json([
            'message' => 'Success',
            'status_code' => 201,
            'access_token' => $token,
            'data' => new UserResource($user),
        ], Response::HTTP_CREATED);
    }

    public function login(Request $request){
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $user = User::whereEmail($request->email)->first();
        if($user->status == 'Banned'){
            return response()->json(['message' => 'Your account is banned or deleted! Please contact our customers service.'], Response::HTTP_UNAUTHORIZED);
        }
        if($request->fcm_token){
            $user->update(['fcm_token' => $request->fcm_token]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'status' => 'Success',
            'access_token' => $token,
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }
}
