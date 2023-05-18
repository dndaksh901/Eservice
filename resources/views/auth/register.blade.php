@extends('layouts.app')

@section('content')
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>

    <div>
        <section class="card vh-100">
            <div class="container h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="{{ asset('imgs/signup.png') }}" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        @isset($url)
                            <form method="POST" action='{{ url("$url/register") }}' aria-label="{{ __('Register') }}">
                            @else
                                <form method="POST" action='{{ route('register') }}' aria-label="{{ __('Register') }}">
                                @endisset
                                @csrf
                                <div
                                    class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                    <h3 class="fw-bold text-center mb-3">{{ isset($url) ? ucwords($url) : '' }}
                                        {{ __('Register') }}</h3>
                                </div>
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Enter Name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-outline mb-4">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Enter Email Address">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-3">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" max="15"
                                        name="password" required autocomplete="new-password" placeholder="Enter Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-outline mb-3">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Password">
                                </div>


                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" class="btn btn-lg"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;background: var(--yellow-color);
                    border-color:var(--yellow-color);color:#ffffff;">{{ __('Register') }}</button>
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Have already an account?

                                        @isset($url)
                                            <a href="{{ url("$url/login") }}"
                                                class="link-danger">{{ isset($url) ? ucwords($url) : '' }}
                                                {{ __('Login') }}</a>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="link-danger">{{ isset($url) ? ucwords($url) : '' }}
                                                {{ __('Login') }}</a>
                                        @endisset

                                    </p>
                                </div>

                            </form>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
