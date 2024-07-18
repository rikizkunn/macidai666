<!DOCTYPE html>
<html lang="en">

<head>
  <!-- --------------------------------------------------- -->
  <!-- Title -->
  <!-- --------------------------------------------------- -->
  <title>@yield('title') | Macidai</title>
  <!-- --------------------------------------------------- -->
  <!-- Required Meta Tag -->
  <!-- --------------------------------------------------- -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="handheldfriendly" content="true" />
  <meta name="MobileOptimized" content="width" />
  <meta name="description" content="Mordenize" />
  <meta name="author" content="" />
  <meta name="keywords" content="Mordenize" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- --------------------------------------------------- -->
  <!-- Favicon -->
  <!-- --------------------------------------------------- -->
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.ico') }} " />
  <!-- --------------------------------------------------- -->
  <!-- Core Css -->
  <!-- --------------------------------------------------- -->
  <link id="themeColors" rel="stylesheet" href="{{ asset('assets/css/style.css') }} " />
  <link id="themeColors" rel="stylesheet" href="{{ asset('assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }} " />

  <!-- --------------------------------------------------- -->
  <!-- Custom Css -->
  <!-- --------------------------------------------------- -->
  @yield('custom_css')
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="{{ asset('assets/images/logos/favicon.ico') }} " alt="loader" class="lds-ripple img-fluid" />
  </div>
  <!-- --------------------------------------------------- -->
  <!-- Body Wrapper -->
  <!-- --------------------------------------------------- -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    @include('layouts.sidebar')
    <!-- --------------------------------------------------- -->
    <!-- Main Wrapper -->
    <!-- --------------------------------------------------- -->
    <div class="body-wrapper">

      @include('layouts.header')

      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <div class="dark-transparent sidebartoggler"></div>
  </div>

  <!-- ---------------------------------------------- -->
  <!-- ---------------------------------------------- -->
  <!-- Import Js Files -->
  <!-- ---------------------------------------------- -->
  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }} "></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }} "></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }} "></script>
  <!-- ---------------------------------------------- -->
  <!-- core files -->
  <!-- ---------------------------------------------- -->
  <script src="{{ asset('assets/js/app.min.js') }} "></script>
  <script src="{{ asset('assets/js/app.init.js') }} "></script>
  <script src="{{ asset('assets/js/app-style-switcher.js') }} "></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }} "></script>
  <script src="{{ asset('assets/js/custom.js') }} "></script>
  <script src="{{ asset('assets/js/plugins/toastr-init.js') }} "></script>
  <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

  <!-- ---------------------------------------------- -->
  <!-- current page js files -->
  <!-- ---------------------------------------------- -->
  @yield('current_js')
  <script src="{{ asset('assets/js/datatable/datatable-basic.init.js') }} "></script>
</body>

</html>