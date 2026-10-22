<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo y nombre del proyecto -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="CancionesArtistas"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">CancionesArtistas</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <!-- request()->routeIs() resalta la opción que corresponde a la ruta actual -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('songs.index') }}"
                       class="nav-link {{ request()->routeIs('songs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-music"></i>
                        <p>Canciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('artists.index') }}"
                       class="nav-link {{ request()->routeIs('artists.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-microphone-alt"></i>
                        <p>Artistas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
