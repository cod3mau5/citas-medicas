@extends('layouts.panel')

@section('title', 'Home')
@section('content')
<div class="row mt-5">
    <div class="col-xl-12 mb-5 mb-xl-0">
        <form method="POST" action="{{route('schedule.store')}}">
            @csrf
            <div class="card bg-default shadow">
                <div class="card-header bg-transparent border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0 text-white">Gestionar Horario</h3>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-sm btn-success">Guardar cambios</button>
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
                <div class="table-responsive bg-transparent">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-dark bg-transparent">
                            <tr>
                            <th scope="col">Día</th>
                            <th scope="col">Activo</th>
                            <th scope="col">Turno Matutino</th>
                            <th scope="col">Turno Vespertino</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach($workDays as $key => $workDay)
                                <tr>

                                    <th scope="row" class="text-white">
                                        {{$days[$key]}}
                                    </th>

                                    <td class="budget">
                                        <label class="custom-toggle">
                                            <input type="checkbox"
                                                   name="active[]"
                                                   value="{{$key}}"
                                                   @if($workDay->active) checked @endif
                                            >
                                            <span class="custom-toggle-slider rounded-circle"></span>
                                        </label>
                                    </td>

                                    <td class="budget">
                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control" name="morning_start[]">
                                                    @for($i = 5; $i <= 11; $i++)
                                                        <option
                                                            value="{{$i}}:00"
                                                            @if($i.':00 AM' == $workDay->morning_start) selected @endif
                                                        >
                                                            {{$i}}:00am
                                                        </option>
                                                        <option
                                                            value="{{$i}}:30"
                                                            @if($i.':30 AM' == $workDay->morning_start) selected @endif
                                                        >
                                                            {{$i}}:30am
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control" name="morning_end[]">
                                                    @for($i = 5; $i <= 11; $i++)
                                                        <option value="{{$i}}:00"
                                                                @if($i.':00 AM' == $workDay->morning_end) selected @endif
                                                        >
                                                            {{$i}}:00am
                                                        </option>
                                                        <option value="{{$i}}:30"
                                                                @if($i.':30 AM' == $workDay->morning_end) selected @endif
                                                        >
                                                            {{$i}}:30am
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="budget">
                                        <div class="row">
                                            <div class="col-6">
                                                <select class="form-control" name="afternoon_start[]">
                                                    @for($i = 1; $i <= 11; $i++)
                                                        <option value="{{$i + 12}}:00"
                                                                @if($i.':00 PM' == $workDay->afternoon_start) selected @endif
                                                        >
                                                            {{$i}}:00pm
                                                        </option>
                                                        <option value="{{$i + 12}}:30"
                                                                @if($i.':30 PM' == $workDay->afternoon_start) selected @endif
                                                        >
                                                            {{$i}}:30pm
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <select class="form-control" name="afternoon_end[]">
                                                    @for($i = 1; $i <= 11; $i++)
                                                        <option value="{{$i + 12}}:00"
                                                                @if($i.':00 PM' == $workDay->afternoon_end) selected @endif
                                                        >
                                                            {{$i}}:00pm
                                                        </option>
                                                        <option value="{{$i + 12}}:30"
                                                                @if($i.':30 PM' == $workDay->afternoon_end) selected @endif
                                                        >
                                                            {{$i}}:30pm
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                    </td>
                                    {{-- <td class="budget">
                                        <a href="{{route('doctors.edit',$doctor->id)}}">
                                            <button class="btn btn-sm btn-primary ">Editar</button>
                                        </a>
                                        <form action="{{route('doctors.destroy',$doctor->id)}}" method="POST" class="d-inline">
                                            <button class="btn btn-sm btn-danger ">Eliminar</button>
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td> --}}

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
