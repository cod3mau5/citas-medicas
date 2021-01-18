<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Controller;


class PatientsController extends Controller
{
    public function index()
    {
        $patients= User::patients()->orderBy('id','desc')->paginate(7);
        return view('patients.index',compact('patients'));
    }


    public function create()
    {
        return view('patients.create');
    }


    public function store(Request $request)
    {
        $rules= [
            'name'=>'required|min:4',
            'email'=>'required|email',
            'cedula'=>'nullable|digits:8',
            'address'=>'nullable|min:5',
            'phone'=>'nullable|min:6'
        ];

        $this->validate($request,$rules);

        User::create(
            $request->only('name','email','cedula','address','phone') + ['role'=>'patient','password'=>Hash::make($request->password)]
        );

        $notification="EL paciente ". $request->name." se ha registrado correctamente";
        return redirect('/patients')->with(compact('notification'));
    }


    public function show($id)
    {
        //
    }


    public function edit(User $patient)
    {
        // dd($patient);
        return view('patients.edit',compact('patient'));
    }


    public function update(Request $request, $id)
    {
        $rules= [
            'name'=>'required|min:4',
            'email'=>'required|email',
            'cedula'=>'nullable|min:8',
            'address'=>'nullable|min:5',
            'phone'=>'nullable|min:6'
        ];

        $this->validate($request,$rules);

        $user= User::patients()->findOrFail($id);
        $data= $request->only('name','email','cedula','address','phone');
        $password=$request->password;
        if($password){
            $data['password']=Hash::make($password);
        }
        $user->update($data);
        $updatedUser=User::patients()->findOrFail($id);

        $notification="La información del paciente ". $updatedUser->name." se ha registrado correctamente";
        return redirect('/patients')->with(compact('notification'));
    }


    public function destroy(User $patient)
    {
        $notification='El paciente '.$patient->name." se ha eliminado correctamente";
        $patient->delete();
        return redirect('/patients')->with(compact('notification'));
    }
}
