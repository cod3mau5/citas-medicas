<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Http\Traits\ValidateAndCreatePatient;

class RegisterController extends Controller
{

    use RegistersUsers;
    use ValidateAndCreatePatient;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }


}
