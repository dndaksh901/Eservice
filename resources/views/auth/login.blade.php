@extends('layouts.main')

@section('content')
    <style>
        .active-text {
            color: #c10037;
        }

        .error {
            color: var(--bs-danger);
            font-weight: bold;
            margin-bottom: 1rem;
        }
    </style>


    <main>
        <div class="breadcrumb-bar">
            <div class="container">
                <div class="row align-items-center text-center">
                    <div class="col-md-12 col-12">

                        <h2 class="breadcrumb-title">Login</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ isset($url) ? ucwords($url) : '' }} Login
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-5 mx-auto">
                        <div class="login-wrap">
                            <div class="interset-btn">
                                <div class="status-toggle d-inline-flex align-items-center">
                                    <span class="@if (!isset($url)) active-text @endif">User</span>
                                    <input type="checkbox" id="check" class="check"
                                        @isset($url) checked @endisset onchange="changePage()" />
                                    <label for="check" class="checktoggle">checkbox</label>
                                    <span class="@if (isset($url)) active-text @endif">Vendor</span>
                                </div>
                            </div>
                            <div>
                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="error">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                {{-- show error message of middleware vendor status --}}
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>

                            <div class="login-header">
                                <h3>{{ isset($url) ? 'Vendor' : 'User' }} Login</h3>
                                {{-- <h4>Welcome Back</h4> --}}
                                <p>Please Enter your Details</p>
                            </div>

                            @isset($url)
                                <form method="POST" action='{{ url("$url/login") }}' aria-label="{{ __('Login') }}">
                                @else
                                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                    @endisset
                                    @csrf
                                    <div class="form-group group-img">
                                        <div class="group-img">
                                            <i class="feather-mail"></i>
                                            <input type="text" class="form-control" placeholder="Email Address"
                                                name="email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="pass-group group-img">
                                            <i class="feather-lock"></i>
                                            <input type="password" class="form-control pass-input" placeholder="Password"
                                                name="password" />
                                            <span class="toggle-password feather-eye" id="toggle-password"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <label class="custom_check">

                                                <input class="rememberme" type="checkbox" name="remember" id="remember"
                                                    {{ old('remember') ? 'checked' : '' }}>

                                                <span class="checkmark"></span>Remember Me
                                            </label>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="text-md-end">

                                                @if (Route::has('password.request'))
                                                @isset($url)
                                                <a class="forgot-link" href="{{ route('vendor.password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @else
                                                <a class="forgot-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endisset

                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100 login-btn" type="submit">
                                        Login
                                    </button>
                                    <div class="register-link text-center">
                                        <p>
                                            No account yet?
                                            @isset($url)
                                                <a href="{{ url("$url/register") }}"
                                                    class="forgot-link">{{ isset($url) ? ucwords($url) : '' }}
                                                    {{ __('Register') }}</a>
                                            @else
                                                <a href="{{ route('register') }}"
                                                    class="forgot-link">{{ isset($url) ? ucwords($url) : '' }}
                                                    {{ __('Register') }}</a>
                                            @endisset
                                        </p>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('js')
    <script>
        function changePage() {
            let checkbox = document.getElementById('check');
            if (checkbox.checked) {
                window.location.href = "{{ url('vendor/login') }}";
            } else {
                window.location.href = "{{ url('login') }}";
            }
        }
    </script>
@endpush
