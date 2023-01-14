<?php

namespace App\Http\Controllers\Admin;

use App\Specialty;
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
        $specialties=Specialty::all();
        return view('doctors.create',compact('specialties'));
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

        $user=User::create(
            $request->only('name','email','cedula','address','phone') + ['role'=>'doctor','password'=>Hash::make($request->password)]
        );

        $user->specialties()->attach($request->input('specialties'));
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
        $specialties=Specialty::all();
        return view('doctors.edit',compact('doctor','specialties'));
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
        $user->specialties()->sync($request->input('specialties'));
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
