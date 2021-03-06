@extends('layouts.panel')

@section('title', 'Especialidades')
@section('content')

    <div class="row mt-5">
        <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Pacientes</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('patients.create')}}" class="btn btn-sm btn-success">Nuevo paciente</a>
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
                            <th scope="col">Email</th>
                            <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($patients as $patient)
                                <tr>
                                <th scope="row">
                                    {{$patient->name}}
                                </th>
                                <td>
                                    {{$patient->email}}
                                </td>
                                <td>
                                    {{$patient->description}}
                                </td>
                                <td>
                                    <a href="{{route('patients.edit',$patient->id)}}">
                                        <button class="btn btn-sm btn-primary ">Editar</button>
                                    </a>
                                    <form action="{{route('patients.destroy',$patient->id)}}" method="POST" class="d-inline">
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
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        {{$patients->links()}}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
