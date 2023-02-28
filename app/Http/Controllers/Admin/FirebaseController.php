<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class FirebaseController extends Controller
{
    public function sendAll(Request $request){
        // $recipient= User::whereNotNull('device_token')->pluck('device_token')->toArray();

        // // dd($recipient);
        // // dd(env('FCM_SERVER_KEY', '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'));

        // $fcm=fcm()
        // ->to($recipient)
        // ->notification([
        //     'title'=>$request->input('title'),
        //     'body'=>$request->input('body')
        // ])->send();




        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey=env('FCM_SERVER_KEY','');

        if($serverKey == ''){
            return "No hay server key";
        }

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);

        // FCM response
        // dd($result);


        $notification='Notificacion enviada a todos los usuarios (Android).';
        return back()->with(compact('notification'));

    }
}
