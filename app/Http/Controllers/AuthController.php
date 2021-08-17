<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();

        if(!$user){

            $user = User::create([
                'email' => $fields['email'],
                'password' => bcrypt($fields['password']),
            ]);
        
            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'code' => 201,
                'status' => 'SUCCESS',
                'message' => 'User Successfully Created',
                'user' => $user,
                'access_token' => $token
            ];
        }else{
            $response = [
                'code' => 400,
                'status' => 'FAILED',
                'message' => '“Email already taken',
            ];
        }
        return response($response, $response['code']);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return[
            'message' => 'Logged out',
        ];
    }
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // check email

        $user = User::where('email', $fields['email'])->first();

        // check password

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'code' => 401,
                'status' => 'FAILED',
                'message' => 'Invalid credentials',
            ],401);
        }else{

            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'code' => 201,
                'status' => 'SUCCESS',
                'message' => 'Successfully Lgin',
                'user' => $user,
                'access_token' => $token
            ];
            return response($response, $response['code']);
        }
    }
}
