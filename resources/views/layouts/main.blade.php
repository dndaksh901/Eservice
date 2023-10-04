<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ config('app.name', 'Eservice') }}</title>


    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/aos/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


    @yield('links')
</head>

<body>
    <div class="main-wrapper">
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
    </div>
   {{-- <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script> --}}
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/aos/aos.js') }}"></script>

    <script src="{{ asset('assets/js/backToTop.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ url('admin/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ url('admin/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ url('admin/vendors/datatables.net/jquery.dataTables.min.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ url('admin/js/dataTables.select.min.js') }}"></script>

    <script>
        window.onload = (event) => {
            $.ajax({
                url: "{{ url('ip-address') }}",
                type: 'get',
                success: function(data) {
                    localStorage.removeItem("currentLocation");
                    localStorage.setItem("currentLocation", JSON.stringify(data));
                }
            })

            // $.ajax({
            //     url: "{{ url('get-countries') }}",
            //     type: 'get',
            //     success: function(data) {
            //         console.log(data);
            //     }
            // })
        };
    </script>
    @stack('js')
</body>

</html>
