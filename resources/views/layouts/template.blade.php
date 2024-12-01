<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- <title>{{config('app.name','SIPASTI')}}</title> --}}
  <title>SIPASTI</title>
  <link rel="icon" href="{{ url('/')}}/image/jti-logo.png" type="image/x-icon">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- CSRF token for AJAX requests -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Google Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- FullCalendar CSS -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <!-- SweetAlert2 CSS dari CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">

  <!-- Select 2 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet">

  @stack('css')
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4"
      style="background-color: #2C3941; border-top-right-radius: 24px; border-bottom-right-radius: 24px;">
      <a href="{{ url('/') }}" class="brand-link">
        <img src="polinema_logo.png" class="brand-image img-circle elevation-4" style="opacity: 8">
        <span class="brand-text font-weight-bold">SIPASTI</span>
      </a>

      @if (auth()->user()->user_type->user_type_code === 'ADM')
        @include('layouts.sidebar_admin')
      @elseif (auth()->user()->user_type->user_type_code === 'DSN')
        @include('layouts.sidebar_dosen')
      @elseif(auth()->user()->user_type->user_type_code === 'PMP')
        @include('layouts.sidebar_pimpinan')
      @endif
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper" style="background-color: white">
      <!-- Breadcrumb -->
      @include('layouts.breadcrumb')

      <!-- Main Content -->
      <section class="content">
        @yield('content')
      </section>
    </div>
  </div>

  <!-- Scripts -->
  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

  <!-- jQuery Validation Plugin -->
  <script src="{{ asset('adminlte\plugins\jquery-validation\jquery.validate.min.js') }}"></script>
  <script src="{{ asset('adminlte\plugins\jquery-validation\additional-methods.min.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- DataTables & Responsive Extension -->
  <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <!-- FullCalendar -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

  <!-- InputMask -->
  <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

  <!-- SweetAlert2 dari CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>


  <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

  <!-- Select 2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>

  <!-- Laravel CSRF Token Setup for AJAX -->
  <script>
    $.ajaxSetup({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
  </script>

  @stack('js')
</body>

</html>