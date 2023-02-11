 <!-- Navigation -->
  <!-- Heading -->
    @if (auth()->user()->role == 'admin')
        <h6 class="navbar-heading text-muted">Gestionar datos</h6>
    @else
        <h6 class="navbar-heading text-muted">Menú</h6>
    @endif
        <ul class="navbar-nav">
            @include('includes.panel.menu.' . auth()->user()->role)
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
