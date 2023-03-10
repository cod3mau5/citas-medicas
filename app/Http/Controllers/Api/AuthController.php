<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Traits\ValidateAndCreatePatient;
use Illuminate\Http\Request;

use App\User;

class AuthController extends Controller
{
    use ValidateAndCreatePatient;

    public function register(Request $request){

        $user=User::where('email',$request['email'])->first();
        if(!$user){
            $this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

            Auth::login($user);

            $token=$user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success'=> true,
                'user'=> $user,
                'token'=>$token,
            ]);
        }else{
            $token=$user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'success'=>true,
                'user'=> $user,
                'token'=>$token
            ]);
        }

        // if ($response = $this->registered($request, $user)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //             ? new JsonResponse([], 201)
        //             : redirect($this->redirectPath());


        // $validateData=$request->validate([
        //     'name'=>'required|string|max:255',
        //     'email'=>'required|string|email|max:255|unique:users',
        //     'password'=>'required|string'
        // ]);

        // $user=User::create([
        //     'name'=>$validateData['name'],
        //     'email'=>$validateData['email'],
        //     'password' => Hash::make($validateData['password']), // password
        //     'email_verified_at' => null,
        //     'remember_token' => null,
        //     'cedula'=>'123456789',
        //     'address'=> 'Lomas Altas',
        //     'phone'=>'6241640107',
        //     'role'=> 'patient',
        // ]);



    }

    public function login(Request $request){
        // if(!Auth::attempt($request->only('email','password'))){
        //     return response()->json([
        //         'message'=> 'Invalid login details.'
        //     ],401);
        // }

        $user= User::where('email',$request['email'])->firstOrFail();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success'=>false,
                'message'=> 'The provided credentials are incorrect.'
            ],401);
        }

        $token=$user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success'=>true,
            'user'=> $user,
            'token'=>$token
        ]);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json([
            'success'=>true
        ],200);
    }


}
