@extends('layouts.main')

@section('content')
<style>
    .active-text {
        color: #c10037;
    }
</style>
<main>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Create an Account</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ isset($url) ? ucwords($url) : "" }} Register</li>
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
                    <div class="login-wrap register-form">
                        <div class="login-header">
                            <div class="interset-btn">
                                <div class="status-toggle d-inline-flex align-items-center">
                                    <span class="@if(!isset($url)) active-text @endif">User</span>
                                    <input type="checkbox" id="check" class="check" @isset($url) checked @endisset onchange="changePage()"/>
                                    <label for="check" class="checktoggle">checkbox</label>
                                    <span class="@if(isset($url)) active-text @endif">Vendor</span>
                                </div>
                            </div>
                            <h3>Create an Account</h3>
                            <p>Lets start with <span>{{ env('APP_NAME') }}</span></p>
                        </div>
                        @isset($url)
                        <form method="POST" action='{{ url("$url/register") }}' aria-label="{{ __('Register') }}">
                        @else
                        <form method="POST" action='{{ route('register') }}' aria-label="{{ __('Register') }}">
                        @endisset
                            @csrf
                            <div class="form-group group-img">
                                <div class="group-img">
                                    <i class="feather-user"></i>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" value="{{ old('name') }}">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group group-img">
                                <div class="group-img">
                                    <i class="feather-mail"></i>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" name="email" id="email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="pass-group group-img">
                                    <i class="feather-lock"></i>
                                    <input type="password" class="form-control pass-input @error('password') is-invalid @enderror" min="5" max="15" name="password" id="password" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="pass-group group-img">
                                    <i class="feather-lock"></i>
                                    <input type="password" class="form-control confirm-pass-input" min="5" max="15" name="password_confirmation" id="password-confirm" placeholder="Confirm Password">
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 login-btn" type="submit">Create Account</button>
                            <div class="register-link text-center">
                                <p>Already have an account?
                                    @isset($url)
                                    <a href="{{ url("$url/login") }}" class="forgot-link">{{ isset($url) ? ucwords($url) : '' }} {{ __('Login') }}</a>
                                    @else
                                    <a href="{{ route('login') }}" class="forgot-link">{{ isset($url) ? ucwords($url) : '' }} {{ __('Login') }}</a>
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
            window.location.href = "{{ url('vendor/register') }}";
        } else {
            window.location.href = "{{ url('register') }}";
        }
    }
</script>
@endpush
