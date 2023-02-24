<?php

namespace App\Http\Traits;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;

trait ValidateAndCreatePatient
{
    protected function validator(array $data)
    {
        return Validator::make($data, User::$rules);
    }


    protected function create(array $data)
    {
        return User::createPatient($data);
    }
}
