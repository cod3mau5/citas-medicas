<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request){
        $validateData=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string'
        ]);

        $user=User::create([
            'name'=>$validateData['name'],
            'email'=>$validateData['email'],
            'password' => Hash::make($validateData['password']), // password
            'email_verified_at' => null,
            'remember_token' => null,
            'cedula'=>'123456789',
            'address'=> 'Lomas Altas',
            'phone'=>'6241640107',
            'role'=> 'patient',
        ]);
        $token=$user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }
    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'message'=> 'Invalid login details.'
            ],401);
        }

        $user= User::where('email',$request['email'])->firstOrFail();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'Bearer'
        ]);
    }
    public function userinfo(Request $request){
        return $request->user();
    }
}
