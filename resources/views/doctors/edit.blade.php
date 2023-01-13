@extends('layouts.panel')

@section('title', 'Crear especialidad')
@section('content')

    <div class="row mt-5">

        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Editar médico</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('doctors.index')}}" class="btn btn-sm btn-warning">Cancelar y volver</a>
                        </div>
                    </div>
                </div>
               <div class="card-body">
                  @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <strong>Error! </strong>{{$error}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('doctors.update',$doctor->id)}}" method="POST">
                        <div class="form-group">
                            <label for="name">Nombre del médico:</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{old('name',$doctor->name)}}" >
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" name="email" class="form-control" id="email" value="{{old('email',$doctor->email)}}" >
                        </div>
                         <div class="form-group">
                            <label for="cedula">Cedula:</label>
                            <input type="text" name="cedula" class="form-control" id="cedula" value="{{old('cedula',$doctor->cedula)}}" >
                        </div>
                         <div class="form-group">
                            <label for="address">Dirección:</label>
                            <input type="text" name="address" class="form-control" id="address" value="{{old('address',$doctor->address)}}" >
                        </div>
                         <div class="form-group">
                            <label for="phone">Teléfono:</label>
                            <input type="text" name="phone" class="form-control" id="phone" value="{{old('phone',$doctor->phone)}}" >
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="text" name="password" class="form-control" id="password" value="" >
                            <p> <em><small>(Ingrese un valor solo si desea modificar la contraseña)</small></em></p>
                        </div>
                        <button type="submit" class="btn btn-default float-right">Guardar</button>
                        @csrf
                        @method('PUT')
                    </form>
               </div>
            </div>
        </div>

    </div>

@endsection
