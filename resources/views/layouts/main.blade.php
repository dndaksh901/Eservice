<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ env('APP_URL') }}">
    <title>{{ config('app.name', 'SkilledWorker') }}</title>
    <meta name="description" content="Looking for a reliable plumber? Connect with skilled plumbers for all your plumbing needs. Fast, efficient, and licensed professionals.From carpentry projects to furniture repairs, our expert carpenters have you covered. Get the best carpentry services near you.Electrical issues? Find licensed electricians for safe and reliable solutions. We ensure your electrical systems work flawlessly.Turn your space into a masterpiece with our interior designers. Creative, experienced, and ready to transform your home or office.Auto trouble? Trust our skilled mechanics for expert repairs and maintenance. Keep your vehicle running smoothly.Boost your academic success with knowledgeable tutors,teacher,lecturer. Personalized tutoring for a brighter future.Need a reliable driver? Our professional drivers ensure secure and convenient transportation for all your needs.{{ env('APP_NAME') }}- Your trusted source for skilled workers. Connecting you with the best in the business.">
    <meta name="keywords" content="manpower,plumber, plumbing, leak repair, pipe installation, plumbing services, plumbing company,carpenter, carpentry, woodworking, furniture repair, home renovation, carpentry services,electrician, electrical services, electrical repair, wiring, electrical installation, licensed electrician,interior designer, home decor, interior decorating, interior design services, interior design company,mechanic, auto repair, car maintenance, automotive services, vehicle repair, car mechanic,tutor, tutoring, academic support, online tutoring, subject tutoring, test prep,teacher,teaching,driver, transportation services, chauffeur, driver for hire, transportation company, private driver,rent bike,rental,immigration,consultant,designer,hire,skilled worker,expert,automation,home cleaner,servant,maid,ielts,insitute,college,painter,wall painter,car painter,personal trainer,trainer,guard,security,fashion designer,tailor">
    <meta property="og:title" content="Skilled Worker like electrician,plumber,carpenter,driver,painter,tutor and so on are here"/>
    <meta property="og:site_name" content="{{ env('APP_URL') }}" />
    <meta property="og:type" content="skilledworker" />
    {{-- <meta property="og:image" content="https://www.vocabulary.com/images/icons/facebook-75x75.gif" />     --}}
    <meta property="og:description" content="A lecturer is someone who stands up in front of a class and gives an organized talk designed to teach you something. There are lots of lecturers at colleges and universities."/>

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

    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11372882687">
</script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11372882687');
</script>
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
