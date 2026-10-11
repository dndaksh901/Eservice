@extends('layouts.main')

@section('meta_title', 'Provider Profile Details | ' . config('app.name', 'Eservice'))

@section('links')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
<style>
    body {
        background-color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .breadcrumb-bar {
        display: none !important;
    }
    .dashboard-content {
        padding: 120px 0 70px !important;
    }

    /* Cards & Containers */
    .vp-dash-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        padding: 28px 26px;
        margin-bottom: 24px;
    }
    .vp-card-header-styled {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        margin-bottom: 22px;
        border-bottom: 1px solid #f1f5f9;
    }
    .vp-card-header-styled h4 {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 9px;
    }

    /* Avatar Upload Preview Box */
    .vp-avatar-upload-box {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 18px 20px;
        background: #f8fafc;
        border-radius: 14px;
        border: 1px dashed #cbd5e1;
        margin-bottom: 24px;
    }
    .vp-upload-preview {
        width: 82px;
        height: 82px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        background: #e2e8f0;
    }
    .btn-file-upload {
        background: #c10037;
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 700;
        padding: 9px 18px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        margin-bottom: 4px;
    }
    .btn-file-upload:hover {
        background: #a1002e;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 0, 55, 0.25);
    }

    /* Form Fields */
    .vp-form-group {
        margin-bottom: 18px;
    }
    .vp-form-label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }
    .vp-input-wrapper {
        position: relative;
    }
    .vp-input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 15px;
        pointer-events: none;
    }
    .vp-form-input {
        width: 100%;
        height: 48px;
        padding: 10px 14px 10px 42px;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        font-size: 14px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .vp-form-input:focus {
        border-color: #c10037;
        box-shadow: 0 0 0 3px rgba(193, 0, 55, 0.1);
    }
    .vp-form-input[readonly] {
        background-color: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }
    .vp-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 11px;
        font-size: 14px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    .vp-textarea:focus {
        border-color: #c10037;
        box-shadow: 0 0 0 3px rgba(193, 0, 55, 0.1);
    }
    .vp-toggle-eye {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        cursor: pointer;
        font-size: 16px;
    }
    .vp-toggle-eye:hover {
        color: #0f172a;
    }

    /* Gender Pill Radios */
    .gender-pill-group {
        display: flex;
        gap: 10px;
    }
    .gender-pill {
        flex: 1;
        position: relative;
    }
    .gender-pill input {
        display: none;
    }
    .gender-pill label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 11px 14px;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        margin: 0;
    }
    .gender-pill input:checked + label {
        background: rgba(193, 0, 55, 0.08);
        border-color: #c10037;
        color: #c10037;
    }

    /* Submit Button */
    .btn-save-profile {
        background: linear-gradient(135deg, #c10037 0%, #e11d48 100%);
        color: #ffffff !important;
        font-size: 14.5px;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 11px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        box-shadow: 0 4px 14px rgba(193, 0, 55, 0.25);
        transition: all 0.2s;
    }
    .btn-save-profile:hover {
        background: linear-gradient(135deg, #a1002e 0%, #be123c 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(193, 0, 55, 0.35);
    }
</style>

<div class="dashboard-content">
    <div class="container">

        <!-- Modern Vendor Tabs -->
        @include('includes.tabs')

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 py-3 px-4 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 py-3 px-4 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Left Column: Personal Information Form (col-lg-8) -->
            <div class="col-lg-8">
                <div class="vp-dash-card">
                    <div class="vp-card-header-styled">
                        <h4><i class="feather-user text-primary"></i> Personal Details & Bio</h4>
                        <span class="text-muted small">Update your public profile details</span>
                    </div>

                    <form action="{{ url('vendor/update-personal-detail') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Profile Photo Upload -->
                        @php $avatar = Auth::guard('vendor')->user()->avatar ?? 'avatar.jpg'; @endphp
                        <div class="vp-avatar-upload-box">
                            <img src="{{ asset('vendor/vendor_image/' . $avatar) }}"
                                 onerror="this.onerror=null;this.src='{{ asset('vendor/vendor_image/avatar.jpg') }}';"
                                 class="vp-upload-preview"
                                 id="avatar-preview-img"
                                 alt="Profile Avatar">
                            <div>
                                <input type="file" accept="image/*" id="avatar" name="avatar" class="d-none" onchange="previewAvatar(this)">
                                <label for="avatar" class="btn-file-upload">
                                    <i class="feather-upload"></i> Upload New Photo
                                </label>
                                <span class="text-muted small d-block">Recommended: Square JPG or PNG &bull; Max 2MB</span>
                            </div>
                        </div>

                        <!-- Full Name & Username -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Full Name*</label>
                                    <div class="vp-input-wrapper">
                                        <span class="vp-input-icon"><i class="feather-user"></i></span>
                                        <input type="text" class="vp-form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::guard('vendor')->user()->name) }}" required>
                                    </div>
                                    @error('name')
                                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Username (System Handle)</label>
                                    <div class="vp-input-wrapper">
                                        <span class="vp-input-icon"><i class="feather-at-sign"></i></span>
                                        <input type="text" class="vp-form-input" readonly value="{{ Auth::guard('vendor')->user()->username }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Phone & Email -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Phone Number*</label>
                                    <div class="vp-input-wrapper">
                                        <span class="vp-input-icon"><i class="feather-phone"></i></span>
                                        <input type="tel" class="vp-form-input @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile', Auth::guard('vendor')->user()->mobile) }}" required>
                                    </div>
                                    @error('mobile')
                                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Email Address</label>
                                    <div class="vp-input-wrapper">
                                        <span class="vp-input-icon"><i class="feather-mail"></i></span>
                                        <input type="email" class="vp-form-input" readonly value="{{ Auth::guard('vendor')->user()->email }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DOB & Gender -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Date of Birth</label>
                                    <div class="vp-input-wrapper">
                                        <span class="vp-input-icon"><i class="feather-calendar"></i></span>
                                        <input type="date" class="vp-form-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob', Auth::guard('vendor')->user()->dob) }}" id="dob">
                                    </div>
                                    @error('dob')
                                        <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="vp-form-group">
                                    <label class="vp-form-label">Gender</label>
                                    <div class="gender-pill-group">
                                        <div class="gender-pill">
                                            <input type="radio" id="gender-male" name="gender" value="male" {{ old('gender', Auth::guard('vendor')->user()->gender) == 'male' ? 'checked' : '' }}>
                                            <label for="gender-male"><i class="fas fa-mars"></i> Male</label>
                                        </div>
                                        <div class="gender-pill">
                                            <input type="radio" id="gender-female" name="gender" value="female" {{ old('gender', Auth::guard('vendor')->user()->gender) == 'female' ? 'checked' : '' }}>
                                            <label for="gender-female"><i class="fas fa-venus"></i> Female</label>
                                        </div>
                                        <div class="gender-pill">
                                            <input type="radio" id="gender-other" name="gender" value="other" {{ old('gender', Auth::guard('vendor')->user()->gender) == 'other' ? 'checked' : '' }}>
                                            <label for="gender-other">Other</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bio / Description -->
                        <div class="vp-form-group">
                            <label class="vp-form-label">Introduction / Short Bio</label>
                            <textarea rows="4" class="vp-textarea @error('introduction') is-invalid @enderror" id="introduction" name="introduction" maxlength="1000" placeholder="Introduce yourself, your work ethic, and background...">{{ old('introduction', Auth::guard('vendor')->user()->introduction ?? '') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <span class="text-muted small">Highlights your craftsmanship to prospective clients.</span>
                                <span class="text-muted small" id="introduction_count">Max 1000 chars</span>
                            </div>
                        </div>

                        <!-- Social Handles -->
                        <div class="pt-2 mb-3 border-top">
                            <label class="vp-form-label mb-2 text-uppercase text-muted" style="letter-spacing:0.04em;">Social Profiles (Optional)</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="vp-form-group">
                                        <div class="vp-input-wrapper">
                                            <span class="vp-input-icon"><i class="fab fa-facebook-f text-primary"></i></span>
                                            <input type="url" class="vp-form-input" placeholder="Facebook URL" name="facebook" value="{{ Auth::guard('vendor')->user()->facebook ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="vp-form-group">
                                        <div class="vp-input-wrapper">
                                            <span class="vp-input-icon"><i class="fab fa-twitter text-info"></i></span>
                                            <input type="url" class="vp-form-input" placeholder="Twitter URL" name="twitter" value="{{ Auth::guard('vendor')->user()->twitter ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="vp-form-group">
                                        <div class="vp-input-wrapper">
                                            <span class="vp-input-icon"><i class="fab fa-instagram text-danger"></i></span>
                                            <input type="url" class="vp-form-input" placeholder="Instagram URL" name="instagram" value="{{ Auth::guard('vendor')->user()->instagram ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="vp-form-group">
                                        <div class="vp-input-wrapper">
                                            <span class="vp-input-icon"><i class="fab fa-youtube text-danger"></i></span>
                                            <input type="url" class="vp-form-input" placeholder="YouTube URL" name="youtube" value="{{ Auth::guard('vendor')->user()->youtube ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn-save-profile" type="submit">
                            <i class="feather-check-circle"></i> Save Profile Details
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Security / Change Password (col-lg-4) -->
            <div class="col-lg-4">
                <div class="vp-dash-card">
                    <div class="vp-card-header-styled">
                        <h4><i class="feather-shield text-danger"></i> Change Password</h4>
                    </div>

                    <form action="{{ url('vendor/update-current-password') }}" method="post">
                        @csrf
                        <div class="vp-form-group">
                            <label class="vp-form-label">Current Password</label>
                            <div class="vp-input-wrapper">
                                <span class="vp-input-icon"><i class="feather-lock"></i></span>
                                <input type="password" class="vp-form-input" placeholder="Enter current password" id="current_password" name="current_password" required autocomplete="current-password">
                                <span class="vp-toggle-eye" onclick="togglePassField('current_password', this)"><i class="feather-eye"></i></span>
                            </div>
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-form-label">New Password (Min. 6 chars)</label>
                            <div class="vp-input-wrapper">
                                <span class="vp-input-icon"><i class="feather-key"></i></span>
                                <input type="password" class="vp-form-input" placeholder="New password" id="new_password" name="password" minlength="6" required autocomplete="new-password">
                                <span class="vp-toggle-eye" onclick="togglePassField('new_password', this)"><i class="feather-eye"></i></span>
                            </div>
                        </div>

                        <div class="vp-form-group">
                            <label class="vp-form-label">Confirm New Password</label>
                            <div class="vp-input-wrapper">
                                <span class="vp-input-icon"><i class="feather-check"></i></span>
                                <input type="password" class="vp-form-input" placeholder="Confirm new password" id="confirm_password" name="confirm_password" minlength="6" required autocomplete="new-password">
                                <span class="vp-toggle-eye" onclick="togglePassField('confirm_password', this)"><i class="feather-eye"></i></span>
                            </div>
                        </div>

                        <button class="btn-save-profile w-100 justify-content-center" type="submit">
                            <i class="feather-lock"></i> Update Password
                        </button>
                    </form>
                </div>

                <!-- Account Security Tips -->
                <div class="vp-dash-card bg-light border-0">
                    <h5 class="fw-bold text-dark fs-6 mb-2"><i class="fas fa-lightbulb text-warning me-1"></i> Security Best Practices</h5>
                    <ul class="text-muted small ps-3 mb-0">
                        <li class="mb-1">Use at least 8 characters with numbers and symbols.</li>
                        <li class="mb-1">Keep your mobile number updated for direct customer booking SMS.</li>
                        <li>Do not share your vendor credentials with unauthorized third parties.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatar-preview-img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function togglePassField(fieldId, iconElem) {
        var field = document.getElementById(fieldId);
        var icon = iconElem.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'feather-eye-off';
        } else {
            field.type = 'password';
            icon.className = 'feather-eye';
        }
    }

    $(document).ready(function() {
        $('#introduction').on('input', function() {
            var len = $(this).val().length;
            $('#introduction_count').text(len + ' / 1000 characters');
        });
    });
</script>
@endpush
