<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request){
        return $request->user();
    }
    public function update(Request $request){
        $user= $request->user();
        $user->name= $request->name;
        $user->email= $request->email ? $request->email : $user->email;
        $user->phone= $request->phone;
        $user->address= $request->address;
        $user->save();
        return $user;
    }
}
