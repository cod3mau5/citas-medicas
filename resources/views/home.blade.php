@extends('layouts.panel')

@section('title', 'Home')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Bienvenido! porfavor selecciona una opcion dentro del menu lateral izquierdo.
                </div>
            </div>
        </div>
        @if (auth()->user()->role=='admin')
            <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card bg-gradient-danger shadow">
                <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                    <h6 class="text-uppercase text-light ls-1 mb-1">Notificacion General</h6>
                    <h2 class="text-white mb-0">Enviar a todos los usuarios</h2>
                    </div>
                </div>
                </div>
                <div class="card-body">
                    @if (Session::has('notification'))
                        <div class="alert alert-success">
                            <p style="font-weight:bolder;margin-bottom:0;font-size:14px">{{ Session::get('notification') }}</p>
                        </div>
                    @endif
                <!-- Chart -->
                <div class="chart text-white">
                    <form action="{{route('FCMWeb')}}" method="POST">
                        <div class="form-group">
                            <label for="title">Titulo</label>
                            <input id="title" class="form-control" name="title" type="text" value="{{config('app.name')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Mensaje</label>
                            <textarea id="body"
                                        class="form-control"
                                        name="body"
                                        rows="2"
                                        required
                            ></textarea>
                    </div>
                    <button class="btn btn-default float-right">Enviar notificacion</button>
                    @csrf
                    </form>
                </div>
                </div>
            </div>
            </div>
        @endif

        <div class="@if(auth()->user()->role=='admin')col-xl-6 @else col-xl-12 @endif">
          <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Total de citas</h6>
                  <h2 class="mb-0 text-secondary">Segun dia de la semana</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-orders" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const appointmentsByDay=@json($appointmentsByDay);
</script>
    <script src="{{url('/js/charts/home.js')}}"></script>
@endsection
