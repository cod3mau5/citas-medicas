<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Controller;

class DoctorsController extends Controller
{

    public function index()
    {
        $doctors= User::doctors()->orderBy('id','desc')->get();
        return view('doctors.index',compact('doctors'));
    }


    public function create()
    {
        return view('doctors.create');
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
            $request->only('name','email','cedula','address','phone') + ['role'=>'doctor','password'=>Hash::make($request->password)]
        );

        $notification="EL médico ". $request->name." se ha registrado correctamente";
        return redirect('/doctors')->with(compact('notification'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $doctor= User::doctors()->findOrFail($id);
        return view('doctors.edit',compact('doctor'));
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

        $user= User::doctors()->findOrFail($id);
        $data= $request->only('name','email','cedula','address','phone');
        $password=$request->password;
        if($password){
            $data['password']=Hash::make($password);
        }
        $user->update($data);
        $updatedUser=User::doctors()->findOrFail($id);

        $notification="La informacion del médico ". $updatedUser->name." se ha registrado correctamente";
        return redirect('/doctors')->with(compact('notification'));
    }


    public function destroy(User $doctor)
    {
        $notification='El medico'.$doctor->name." se ha eliminado correctamente";
        $doctor->delete();
        return redirect('/doctors')->with(compact('notification'));
    }
}
