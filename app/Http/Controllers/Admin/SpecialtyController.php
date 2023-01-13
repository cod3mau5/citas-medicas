<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specialty;
use App\Http\Controllers\Controller;


class SpecialtyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function performValidation(Request $request){
        $rules=[
            'name'=> 'required|min:3',
        ];
        $messages=[
            'name.required'=>'Es necesario ingresar un nombre.',
            'name.min'=>'El nombre de la especialidad debe contener al menos 3 caracteres.'
        ];

        $validation=$this->validate($request,$rules,$messages);
        return $validation;
    }

    public function index(){
        $specialties= Specialty::orderBy('id','desc')->get();
        return view('specialties.index',compact('specialties'));
    }
    public function create(){
        return view('specialties.create');
    }

    public function store(Request $request){

       $this->performValidation($request);

        // if($validation){
        //     Specialty::create($request->except('_token'));
        //     $notification= 'La especialidad se ha creado correctamente.';
        //     return redirect('/specialties')->with(compact('notification'));
        // }else{
        //     return back();
        // }
        Specialty::create($request->except('_token'));
        $notification= 'La especialidad se ha creado correctamente.';
        return redirect('/specialties')->with(compact('notification'));

    }

    public function edit(Specialty $specialty){
        return view('specialties.edit',compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty){

        $this->performValidation($request);

        // if($validation){
        //     $specialty->update($request->except('_token'));

        //     $notification= 'La especialidad '.$specialty->name.' se ha editado correctamente.';
        //     return redirect('/specialties')->with(compact('notification'));
        // }else{
        //     return back();
        // }

        $specialty->update($request->except('_token'));
        $notification= 'La especialidad '.$specialty->name.' se ha editado correctamente.';
        return redirect('/specialties')->with(compact('notification'));

    }

    public function destroy(Specialty $specialty){
        $notification= 'La especialidad '.$specialty->name.' se ha eliminado correctamente.';
        $specialty->delete();
        return redirect('/specialties')->with(compact('notification'));
    }

}
