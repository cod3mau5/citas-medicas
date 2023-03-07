<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(){
        $user= auth()->user();
        return view('profile',compact('user'));
    }
    public function update(Request $request){
        $user= User::find(auth()->user()->id);
        $user->name= $request->name;
        $user->email= $request->email ? $request->email : $user->email;
        $user->phone= $request->phone;
        $user->address= $request->address;
        $user->save();

        $notification='Los datos han sido actualizados satisfactoriamente.';
        return back()->with(compact('notification'));
    }
}
