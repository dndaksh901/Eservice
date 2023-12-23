<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Vendor Dashboard</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ url('admin/vendors/feather/feather.css') }}">
        <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ url('admin/vendors/css/vendor.bundle.base.css') }}">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <link rel="stylesheet" href="{{ url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('admin/js/select.dataTables.min.css') }}">

        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ url('admin/css/vertical-layout-light/style.css') }}">
        <!-- endinject -->
        <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">


        @yield('links')

    </head>
    <body>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            @include('vendor.layout.header')
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_settings-panel.html -->
                @include('vendor.layout.sidebar')
                <!-- partial -->
            <div class="main-panel">

                @yield('content')
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ url('admin/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page -->
        <script src="{{ url('admin/vendors/chart.js/Chart.min.js') }}"></script>
        <script src="{{ url('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
        <script src="{{ url('admin/vendors/datatables.net/jquery.dataTables.min.js') }}"></script>
        <script src="{{ url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ url('admin/js/dataTables.select.min.js') }}"></script>
        <!-- End plugin js for this page -->
        <!-- inject:js -->
        <script src="{{ url('admin/js/off-canvas.js') }}"></script>
        <script src="{{ url('admin/js/hoverable-collapse.js') }}"></script>
        <script src="{{ url('admin/js/template.js') }}"></script>
        <script src="{{ url('admin/js/settings.js') }}"></script>
        <script src="{{ url('admin/js/todolist.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="{{ url('admin/js/dashboard.js') }}"></script>
        <script src="{{ url('admin/js/Chart.roundedBarCharts.js') }}"></script>
        <!-- End custom js for this page-->
        <!-- Select 2 js-->
        {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
        <script src="{{ url('admin/vendors/select2/select2.min.js') }}"></script>
        <!-- End Select 2 js-->

        <script>
            function cl(data){
                console.log(data);
            }
        </script>
        @stack('script')
    </body>
</html>
