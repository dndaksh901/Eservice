<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ config('app.name', 'Eservice') }} Chat</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        html, body {
            min-height: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background: #f2f2f6;
        }
        body {
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .chat-page-header {
            height: 70px;
            background: #075e54;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 24px;
            color: #fff;
        }
        .chat-page-header .chat-logo {
            display: inline-flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            font-size: 22px;
            gap: 10px;
        }
        .chat-page-header .chat-logo img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        .chat-page-body {
            flex: 1;
            overflow: hidden;
        }
        .chat-page-body .chat-page {
            height: 100%;
            margin: 0;
            max-width: none !important;
            border-radius: 0 !important;
        }
    </style>

    @yield('links')
</head>
<body>
    <header class="chat-page-header">
        <a class="chat-logo" href="{{ Auth::guard('vendor')->check() ? url('vendor/dashboard') : route('home') }}">
            <img src="{{ asset('assets/img/favicon.png') }}" alt="Logo">
            <span>{{ config('app.name', 'Eservice') }}</span>
        </a>
    </header>

    <div class="chat-page-body">
        @yield('content')
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('js')
</body>
</html>
