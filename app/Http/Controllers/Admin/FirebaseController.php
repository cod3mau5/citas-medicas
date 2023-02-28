<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FirebaseController extends Controller
{
    public function sendAll(Request $request){
        $recipient= User::whereNotNull('device_token')->pluck('device_token')->toArray();

        // dd($recipient);

        fcm()
        ->to($recipient)
        ->notification([
            'title'=>$request->input('title'),
            'body'=>$request->input('body')
        ])->send();

        $notification='Notificacion enviada a todos los usuarios (Android).';
        return back()->with(compact('notification'));

    }
}
