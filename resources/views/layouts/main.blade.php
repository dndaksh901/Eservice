<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <title>@yield('meta_title', config('app.name', 'Eservice') . ' - Find & Hire Verified Local Experts')</title>
    <meta name="description" content="@yield('meta_description', 'Connect with verified skilled service providers including electricians, plumbers, tutors, drivers, mechanics and home experts near your location.')">
    <meta name="keywords" content="@yield('meta_keywords', 'electrician, plumber, tutor, driver, carpenter, mechanic, skilled workers, home services, hire experts near me')">
    <meta property="og:title" content="@yield('meta_title', config('app.name', 'Eservice') . ' - Find & Hire Verified Local Experts')"/>
    <meta property="og:site_name" content="{{ config('app.name', 'Eservice') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:description" content="@yield('meta_description', 'Find and book verified local skilled professionals in your area.')"/>
    <meta name="twitter:card" content="summary_large_image">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/aos/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}">

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
{{-- <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11372882687');
</script> --}}
   {{-- <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')}}"></script> --}}
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
   <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>

    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/aos/aos.js') }}"></script>

    <script src="{{ asset('assets/js/backToTop.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/js/location.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
    $(document).ready(function() {
        // Function to capitalize the first letter of each word
        function capitalizeWords(str) {
            return str ? str.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            }) : '';
        }

        // Function to fetch IP address and set local storage
        function fetchIPAddress() {
            if (localStorage.getItem("currentLocation")) {
                try {
                    var stored = JSON.parse(localStorage.getItem("currentLocation"));
                    if (stored && stored.countryName) {
                        populateCountrySelect(stored.countryName);
                        return;
                    }
                } catch(e) {}
            }

            $.ajax({
                url: "{{ url('ip-address') }}",
                type: 'get',
                success: function(data) {
                    if (data) {
                        localStorage.setItem("currentLocation", JSON.stringify(data));
                        localStorage.setItem("country", capitalizeWords(data.countryName || 'India'));
                        populateCountrySelect(data.countryName);
                    }
                }
            });
        }

        // Function to populate country select dropdown
        function populateCountrySelect(currentCountry) {
            $.ajax({
                url: "{{ url('get-countries') }}",
                type: 'get',
                success: function(data) {
                    if (data && data.length > 0) {
                        let html = '';
                        $.each(data, function(key, value) {
                            let selected = (capitalizeWords(value.name) === currentCountry) ? 'selected' : '';
                            html += `<option value="${value.id}" ${selected}>${capitalizeWords(value.name)}</option>`;
                        });
                        $('#header-country-select').html(html);

                    }
                }
            });
        }

        // Initial fetch IP address and populate country select on page load
        fetchIPAddress();

        // Event listener for country select change
        $('#header-country-select').change(function() {
            let countryId = $(this).val();
            $.ajax({
                url: "api/active-countries",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    country_id: countryId,
                },
                success: function(response) {
                    if (response) {
                        localStorage.setItem("country", capitalizeWords(response.name));
                        window.location.href="{{ url('/') }}";
                    }
                }
            });
        });

    });
</script>
    @stack('js')
</body>

</html>
