@extends('layouts.panel')

@section('title', 'Especialidades')
@section('content')

    <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Especialidades</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('specialties.create')}}" class="btn btn-sm btn-success">Nueva especialidad</a>
                        </div>
                    </div>
                </div>

                @if(session('notification'))
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <strong>Bien!</strong> {{session('notification')}}
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($specialties as $specialty)
                                <tr>
                                <th scope="row">
                                    {{$specialty->name}}
                                </th>
                                <td>
                                    {{$specialty->description}}
                                </td>
                                <td>
                                    <a href="{{route('specialties.edit',$specialty->id)}}">
                                        <button class="btn btn-sm btn-primary ">Editar</button>
                                    </a>
                                    <form action="{{route('specialties.delete',$specialty->id)}}" method="POST" class="d-inline">
                                        <button class="btn btn-sm btn-danger ">Eliminar</button>
                                        @method('DELETE')
                                        @csrf
                                    </form>
                                </td>

                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
  
    </div>

@endsection
