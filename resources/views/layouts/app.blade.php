<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'CancionesArtistas')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style (AdminLTE 3) -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/dist/css/select2.css') }}">

  @stack('css')

</head>

<!-- layout-fixed deja fijos el sidebar, el navbar y el footer -->
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    @include('layouts.partials.topbar')
    @include('layouts.partials.sidebar')

    <!-- El marco del contenido lo pone el layout; cada vista solo llena 'content' -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('partials.mensajes')
                @yield('content')
            </div>
        </section>
    </div>

    @include('layouts.partials.footer')
</div>
</body>

<!-- jQuery -->
<script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE app (pushmenu, treeview, etc.) -->
<script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- DataTables (debe ir antes de table.js) -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- Select2 (debe ir antes de selectors.js) -->
<script src="{{ asset('backend/plugins/select2/js/select2.min.js') }}"></script>
<!-- Tablas y selectores -->
<script src="{{ asset('backend/dist/js/table.js') }}"></script>
<script src="{{ asset('backend/dist/js/selectors.js') }}"></script>

@stack('scripts')

</html>
