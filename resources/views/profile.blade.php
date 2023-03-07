@extends('layouts.panel')

@section('title', 'Crear cita')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Editar perfil</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/') }}" class="btn btn-sm btn-default">
                        Cancelar y volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('notification'))
                <div class="alert alert-success">
                    <p>{{ Session::get('notification') }}</p>
                </div>
            @endif
            <form action="{{ route('profile.edit') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <input name="name"
                    value="{{ old('name',$user->name) }}"
                    id="name"
                    type="text"
                    class="form-control"
                    placeholder="Escriba su nombre completo." r
                    equired>
                </div>

                <div class="form-group">
                    <label for="phone">Telefono (movil)</label>
                    <input name="phone"
                    value="{{ old('phone',$user->phone) }}"
                    id="phone"
                    type="text"
                    class="form-control"
                    placeholder="Escriba el numero de su telefono mobil." r
                    equired>
                </div>
                <div class="form-group">
                    <label for="address">Direccion</label>
                    <input name="address"
                    value="{{ old('address',$user->address) }}"
                    id="address"
                    type="text"
                    class="form-control"
                    placeholder="Escriba su direccion." r
                    equired>
                </div>
                <button type="submit" class="btn btn-primary">
                    Guardar cambios
                </button>
            </form>
        </div>
    </div>
@endsection

