@extends('layouts.main')

@section('meta_title', 'Create an Account | ' . config('app.name', 'Eservice'))
@section('meta_description', 'Sign up for ' . config('app.name', 'Eservice') . ' to connect directly with top-rated local professionals or offer your skilled services in your city.')

@section('links')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --auth-primary: #c10037;
        --auth-primary-hover: #a1002e;
        --auth-primary-light: rgba(193, 0, 55, 0.08);
        --auth-slate-900: #0f172a;
        --auth-slate-800: #1e293b;
        --auth-slate-700: #334155;
        --auth-slate-600: #475569;
        --auth-slate-500: #64748b;
        --auth-slate-200: #e2e8f0;
        --auth-slate-100: #f1f5f9;
        --auth-slate-50: #f8fafc;
    }

    body {
        background-color: var(--auth-slate-50) !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Auth Page Wrapper */
    .auth-page-wrapper {
        padding: 125px 0 75px;
        min-height: calc(100vh - 120px);
        background: radial-gradient(circle at 10% 20%, rgba(193, 0, 55, 0.03) 0%, transparent 40%),
                    radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.03) 0%, transparent 40%),
                    var(--auth-slate-50);
    }

    /* Left Showcase Panel */
    .auth-showcase {
        padding-right: 28px;
    }
    .auth-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(193, 0, 55, 0.08);
        border: 1px solid rgba(193, 0, 55, 0.15);
        color: var(--auth-primary);
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 12.5px;
        font-weight: 700;
        margin-bottom: 18px;
    }
    .auth-showcase-title {
        font-size: 34px;
        font-weight: 800;
        color: var(--auth-slate-900);
        letter-spacing: -0.025em;
        line-height: 1.25;
        margin-bottom: 14px;
    }
    .auth-showcase-desc {
        font-size: 15.5px;
        color: var(--auth-slate-600);
        line-height: 1.65;
        margin-bottom: 28px;
    }

    /* Value Proposition Features */
    .auth-feature-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }
    .auth-feature-card {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        background: #ffffff;
        border: 1px solid var(--auth-slate-200);
        border-radius: 14px;
        padding: 14px 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .auth-feature-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 17px;
    }
    .auth-icon-red {
        background: rgba(193, 0, 55, 0.1);
        color: var(--auth-primary);
    }
    .auth-icon-green {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }
    .auth-icon-blue {
        background: rgba(2, 132, 199, 0.1);
        color: #0284c7;
    }
    .auth-feature-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--auth-slate-900);
        margin: 0 0 2px;
    }
    .auth-feature-text {
        font-size: 13px;
        color: var(--auth-slate-600);
        margin: 0;
        line-height: 1.45;
    }

    /* Trust Quote Badge */
    .auth-social-proof {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        border: 1px solid var(--auth-slate-200);
        border-radius: 14px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .auth-proof-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .auth-proof-quote {
        font-size: 13px;
        color: var(--auth-slate-700);
        font-style: italic;
        margin: 0 0 3px;
        line-height: 1.4;
    }
    .auth-proof-author {
        font-size: 12px;
        font-weight: 700;
        color: var(--auth-slate-900);
        font-style: normal;
    }

    /* Authentication Form Card */
    .auth-card {
        background: #ffffff;
        border-radius: 22px;
        box-shadow: 0 10px 35px -5px rgba(15, 23, 42, 0.08);
        border: 1px solid rgba(226, 232, 240, 0.95);
        padding: 34px 32px;
        position: relative;
    }

    /* Role Segmented Switcher */
    .auth-role-tabs {
        display: flex;
        background: var(--auth-slate-100);
        padding: 5px;
        border-radius: 12px;
        margin-bottom: 26px;
        border: 1px solid var(--auth-slate-200);
    }
    .auth-role-tab {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 14px;
        font-size: 13.5px;
        font-weight: 700;
        border-radius: 9px;
        text-decoration: none;
        color: var(--auth-slate-600);
        transition: all 0.2s ease;
    }
    .auth-role-tab:hover {
        color: var(--auth-slate-900);
    }
    .auth-role-tab.active {
        background: var(--auth-primary);
        color: #ffffff !important;
        box-shadow: 0 3px 10px rgba(193, 0, 55, 0.25);
    }

    /* Card Header */
    .auth-card-header {
        margin-bottom: 24px;
        text-align: left;
    }
    .auth-card-title {
        font-size: 24px;
        font-weight: 800;
        color: var(--auth-slate-900);
        letter-spacing: -0.02em;
        margin: 0 0 6px;
    }
    .auth-card-subtitle {
        font-size: 14px;
        color: var(--auth-slate-500);
        margin: 0;
    }

    /* Form Inputs */
    .auth-input-group {
        position: relative;
        margin-bottom: 16px;
    }
    .auth-input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--auth-slate-500);
        font-size: 16px;
        pointer-events: none;
        transition: color 0.2s;
    }
    .auth-input-field {
        width: 100%;
        height: 50px;
        padding: 12px 16px 12px 46px;
        border: 1.5px solid var(--auth-slate-200);
        border-radius: 12px;
        font-size: 14.5px;
        color: var(--auth-slate-900);
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .auth-input-field:focus {
        border-color: var(--auth-primary);
        box-shadow: 0 0 0 4px rgba(193, 0, 55, 0.1);
    }
    .auth-input-field:focus + .auth-input-icon,
    .auth-input-group:focus-within .auth-input-icon {
        color: var(--auth-primary);
    }
    .auth-input-field.is-invalid {
        border-color: #dc3545;
        background-image: none;
    }
    .auth-toggle-pass {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--auth-slate-500);
        font-size: 16px;
        cursor: pointer;
        padding: 4px;
        transition: color 0.2s;
    }
    .auth-toggle-pass:hover {
        color: var(--auth-slate-900);
    }
    .auth-field-error {
        color: #dc3545;
        font-size: 12px;
        font-weight: 600;
        margin-top: 4px;
        display: block;
        padding-left: 4px;
    }

    /* Submit Button */
    .auth-submit-btn {
        width: 100%;
        padding: 13px 20px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        color: #ffffff;
        background: linear-gradient(135deg, #c10037 0%, #e11d48 100%);
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(193, 0, 55, 0.32);
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 8px;
    }
    .auth-submit-btn:hover {
        background: linear-gradient(135deg, #a1002e 0%, #be123c 100%);
        box-shadow: 0 6px 20px rgba(193, 0, 55, 0.42);
        transform: translateY(-1.5px);
    }

    /* Card Footer Switch Link */
    .auth-switch-prompt {
        text-align: center;
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid var(--auth-slate-100);
        font-size: 14px;
        color: var(--auth-slate-600);
    }
    .auth-switch-prompt a {
        color: var(--auth-primary);
        font-weight: 700;
        text-decoration: none;
        margin-left: 4px;
    }
    .auth-switch-prompt a:hover {
        text-decoration: underline;
    }

    /* Security Notice */
    .auth-security-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 18px;
        font-size: 12px;
        color: var(--auth-slate-500);
    }
    .auth-security-badge i {
        color: #10b981;
    }

    @media (max-width: 991px) {
        .auth-page-wrapper {
            padding: 110px 0 60px;
        }
        .auth-card {
            padding: 28px 22px;
        }
    }
</style>
@endsection

@section('content')
<main class="auth-page-wrapper">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">

            <!-- Left Column: Trust & Ecosystem Showcase (Desktop only) -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="auth-showcase">
                    <span class="auth-pill-badge">
                        <i class="fas fa-sparkles text-warning"></i> Fast, Free & 100% Direct
                    </span>
                    <h1 class="auth-showcase-title">
                        Join Thousands of Customers & Local Service Pros
                    </h1>
                    <p class="auth-showcase-desc">
                        Whether you need immediate help with home repairs or want to showcase your skilled craft to local clients, {{ config('app.name', 'Eservice') }} makes it effortless.
                    </p>

                    <div class="auth-feature-list">
                        <div class="auth-feature-card">
                            <div class="auth-feature-icon auth-icon-red">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h4 class="auth-feature-title">Instant Setup in Under 1 Minute</h4>
                                <p class="auth-feature-text">Create your profile, select your requirements, and begin hiring or taking client requests immediately.</p>
                            </div>
                        </div>

                        <div class="auth-feature-card">
                            <div class="auth-feature-icon auth-icon-green">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <h4 class="auth-feature-title">Zero Hidden Fees or Markups</h4>
                                <p class="auth-feature-text">No high platform commissions. Direct connections and honest pricing between customers and professionals.</p>
                            </div>
                        </div>

                        <div class="auth-feature-card">
                            <div class="auth-feature-icon auth-icon-blue">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div>
                                <h4 class="auth-feature-title">Extensive Service Categories</h4>
                                <p class="auth-feature-text">Electricians, Plumbers, Carpenters, Mechanics, Tutors, Painters, and more all in one trusted hub.</p>
                            </div>
                        </div>
                    </div>

                    <div class="auth-social-proof">
                        <img src="{{ asset('assets/img/testimonial-thumb.jpg') }}" onerror="this.onerror=null;this.src='{{ asset('vendor/vendor_image/avatar.jpg') }}';" class="auth-proof-avatar" alt="Client">
                        <div>
                            <div class="text-warning small mb-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="auth-proof-quote">"As an independent technician, Eservice gave me direct customer leads without cutting 30% commission. Game changer!"</p>
                            <span class="auth-proof-author">Rohit Verma &bull; Certified Professional</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Column: Registration Card -->
            <div class="col-lg-6 col-md-9 col-sm-12">
                <div class="auth-card">

                    <!-- Role Switcher (Customer vs Vendor) -->
                    <div class="auth-role-tabs">
                        <a href="{{ url('register') }}" class="auth-role-tab @if(!isset($url)) active @endif">
                            <i class="feather-user"></i>
                            <span>I'm a Customer</span>
                        </a>
                        <a href="{{ url('vendor/register') }}" class="auth-role-tab @if(isset($url) && $url == 'vendor') active @endif">
                            <i class="feather-briefcase"></i>
                            <span>Service Provider</span>
                        </a>
                    </div>

                    <!-- Card Header -->
                    <div class="auth-card-header">
                        <h2 class="auth-card-title">Create {{ isset($url) ? 'Provider' : 'Customer' }} Account</h2>
                        <p class="auth-card-subtitle">Get started with {{ config('app.name', 'Eservice') }} in just a few steps.</p>
                    </div>

                    <!-- Alerts & Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 py-2 px-3 mb-3 small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    @isset($url)
                        <form method="POST" action='{{ url("$url/register") }}' aria-label="{{ __('Register') }}">
                    @else
                        <form method="POST" action='{{ route('register') }}' aria-label="{{ __('Register') }}">
                    @endisset
                        @csrf

                        <!-- Full Name Field -->
                        <div class="auth-input-group">
                            <input type="text" class="auth-input-field @error('name') is-invalid @enderror" placeholder="Full Name" name="name" id="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                            <span class="auth-input-icon"><i class="feather-user"></i></span>
                            @error('name')
                                <span class="auth-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Address Field -->
                        <div class="auth-input-group">
                            <input type="email" class="auth-input-field @error('email') is-invalid @enderror" placeholder="Email Address" name="email" id="email" value="{{ old('email') }}" required autocomplete="email">
                            <span class="auth-input-icon"><i class="feather-mail"></i></span>
                            @error('email')
                                <span class="auth-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="auth-input-group">
                            <input type="password" class="auth-input-field @error('password') is-invalid @enderror" min="6" name="password" id="register-password" placeholder="Password (Min. 6 characters)" required autocomplete="new-password">
                            <span class="auth-input-icon"><i class="feather-lock"></i></span>
                            <span class="auth-toggle-pass" id="toggle-reg-pass-btn" title="Toggle password visibility">
                                <i class="feather-eye" id="toggle-reg-pass-icon"></i>
                            </span>
                            @error('password')
                                <span class="auth-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="auth-input-group">
                            <input type="password" class="auth-input-field" min="6" name="password_confirmation" id="register-password-confirm" placeholder="Confirm Password" required autocomplete="new-password">
                            <span class="auth-input-icon"><i class="feather-shield"></i></span>
                            <span class="auth-toggle-pass" id="toggle-reg-confirm-btn" title="Toggle password visibility">
                                <i class="feather-eye" id="toggle-reg-confirm-icon"></i>
                            </span>
                        </div>

                        <!-- Submit CTA -->
                        <button class="auth-submit-btn" type="submit">
                            <i class="feather-user-plus me-1"></i> Create Free Account
                        </button>

                        <!-- Switch Link -->
                        <div class="auth-switch-prompt">
                            Already have an account?
                            @isset($url)
                                <a href="{{ url("$url/login") }}">Sign In as Provider</a>
                            @else
                                <a href="{{ route('login') }}">Sign In to Account</a>
                            @endisset
                        </div>

                        <!-- Security Badge -->
                        <div class="auth-security-badge">
                            <i class="fas fa-lock"></i> 256-Bit SSL Encrypted & Secure Authentication
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</main>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#toggle-reg-pass-btn').on('click', function() {
            var $pwd = $('#register-password');
            var $icon = $('#toggle-reg-pass-icon');
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
                $icon.removeClass('feather-eye').addClass('feather-eye-off');
            } else {
                $pwd.attr('type', 'password');
                $icon.removeClass('feather-eye-off').addClass('feather-eye');
            }
        });

        $('#toggle-reg-confirm-btn').on('click', function() {
            var $pwd = $('#register-password-confirm');
            var $icon = $('#toggle-reg-confirm-icon');
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
                $icon.removeClass('feather-eye').addClass('feather-eye-off');
            } else {
                $pwd.attr('type', 'password');
                $icon.removeClass('feather-eye-off').addClass('feather-eye');
            }
        });
    });
</script>
@endpush
