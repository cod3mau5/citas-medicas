 <!-- Navigation -->
  <!-- Heading -->
  @if (auth()->user()->role == 'admin')
    <h6 class="navbar-heading text-muted">Gestionar datos</h6>
    @else
        <h6 class="navbar-heading text-muted">Menú</h6>
@endif
        <ul class="navbar-nav">
            @if (auth()->user()->role == 'admin') {{-- role == 'admin' --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                    <i class="ni ni-tv-2 text-default"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('specialties.index')}}">
                    <i class="ni ni-paper-diploma text-blue"></i> Especialidades
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('doctors.index')}}">
                    <i class="ni ni-badge text-orange"></i> Médicos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('patients.index')}}">
                    <i class="ni ni-single-02 text-info"></i> Pacientes
                    </a>
                </li>
             @elseif(auth()->user()->role == 'doctor') {{-- role == 'doctor' --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('schedule.edit')}}">
                    <i class="ni ni-calendar-grid-58 text-primary"></i> Gesitonar Horario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('specialties.index')}}">
                    <i class="ni ni-time-alarm text-orange"></i> Mis Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('patients.index')}}">
                    <i class="ni ni-single-02 text-info"></i> Mis Pacientes
                    </a>
                </li>
            @elseif(auth()->user()->role == 'patient') {{-- role == 'patient' --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('specialties.index')}}">
                    <i class="ni ni-laptop text-blue"></i> Reservar Cita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('specialties.index')}}">
                    <i class="ni ni-time-alarm text-orange"></i> Mis Citas
                    </a>
                </li>
          @endif
          <li class="nav-item">
           <form action="{{route('logout')}}" method="POST">
                <button type="submit" class="nav-link" style="border:none;cursor:pointer">
                    <i class="ni ni-key-25"></i> Cerrar sesión
                </button>
                @csrf
            </form>
          </li>
        </ul>
        @if (auth()->user()->role == 'admin') {{-- role == 'admin' --}}
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Reportes</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
                <a class="nav-link" href="#">
                <i class="ni ni-chart-bar-32 text-red"></i> Frecuencia de citas.
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                <i class="ni ni-trophy text-yellow"></i> Médicos más activos.
                </a>
            </li>

            </ul>
        @endif
