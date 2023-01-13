@extends('layouts.panel')

@section('title', 'Crear especialidad')
@section('content')

    <div class="row mt-5">

        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Editar especialidad</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('specialties.index')}}" class="btn btn-sm btn-warning">Cancelar y volver</a>
                        </div>
                    </div>
                </div>
               <div class="card-body">
                  @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <strong>Error! </strong>{{$errors->first()}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('specialties.update',$specialty->id)}}" method="POST">
                        <div class="form-group">
                            <label for="name">Nombre de la especialidad:</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{old('name',$specialty->name)}}" >
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción de la especialidad:</label>
                            <input type="text" name="description" class="form-control" id="description" value="{{old('description',$specialty->description)}}" >
                        </div>
                        <button type="submit" class="btn btn-default float-right">Guardar</button>
                        @method('PUT')
                        @csrf
                    </form>
               </div>
            </div>
        </div>
  
    </div>

@endsection
