@extends('layouts.main')

<style>
    .settings-upload-img,
    .settings-upload-img img {
        object-fit: cover;
        -o-object-fit: cover;
    }
</style>

@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Profile</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="dashboard-content">
        <div class="container">
            <div class="">
                @include('includes.tabs')
            </div>
            <div class="profile-content">
                <div class="row dashboard-info">
                    @if (session()->has('error'))
                        <div class="col-12 alert alert-danger flash-message" data-duration="5000">
                            <strong>{{ session()->get('error') }}</strong>
                            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="col-12 alert alert-success flash-message" data-duration="5000">
                            <strong>{{ session()->get('success') }}</strong>
                            {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button> --}}
                        </div>
                    @endif
                    <div class="col-lg-9">
                        <form action="{{ url('vendor/update-personal_detail') }}" method="post" class="forms-sample"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card dash-cards">
                                <div class="card-header">
                                    <h4>Profile Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="profile-photo">
                                        <div class="profile-img">
                                            @php $avatar=Auth::guard('vendor')->user()->avatar ?? 'avatar.jpg'; @endphp
                                            <div class="settings-upload-img">
                                                <img src="{{ asset('vendor/vendor_image/' . $avatar) }}" alt="profile">
                                            </div>
                                            <div class="settings-upload-btn">
                                                <input type="file" accept="image/*" id="avatar" name="avatar"
                                                    class="hide-input image-upload">
                                                <label for="file" class="file-upload">Upload New photo</label>
                                            </div>
                                            <span>Max file size: 1 MB</span>
                                        </div>
                                        <a href="javascript:void(0)" class="profile-img-del d-none" onclick="delImage()"><i
                                                class="feather-trash-2"></i></a>
                                    </div>
                                    <div class="profile-form">

                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Your Full Name</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="feather-user"></i></span>
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ Auth::guard('vendor')->user()->name }}">
                                                    </div>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Username</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="feather-user"></i></span>
                                                        <input type="text" class="form-control" readonly
                                                            value="{{ Auth::guard('vendor')->user()->username }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Phone Number</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="feather-phone-call"></i></span>
                                                        <input type="tel" class="form-control" name="mobile"
                                                            value="{{ Auth::guard('vendor')->user()->mobile }}">
                                                    </div>
                                                    @error('mobile')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Email Address</label>
                                                    <div class="group-img">
                                                        <i class="feather-mail"></i>
                                                        <input type="text" class="form-control" readonly
                                                            value="{{ Auth::guard('vendor')->user()->email }}" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth</label>
                                                    <input type="date" class="form-control" name="dob"
                                                        value="{{ Auth::guard('vendor')->user()->dob }}" id="dob">
                                                    @error('dob')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <br>
                                                    <div class="d-flex justify-content-between">
                                                        <!-- Default inline 1-->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input"
                                                                id="gender1" name="gender" value="male"
                                                                {{ Auth::guard('vendor')->user()->gender == 'male' ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="gender1">Male</label>
                                                        </div>

                                                        <!-- Default inline 2-->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input"
                                                                id="gender2" name="gender" value="female"
                                                                {{ Auth::guard('vendor')->user()->gender == 'female' ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="gender2">Female</label>
                                                        </div>

                                                        <!-- Default inline 3-->
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" class="custom-control-input"
                                                                id="gender3" name="gender" value="other"
                                                                {{ Auth::guard('vendor')->user()->gender == 'other' ? 'checked' : '' }}>
                                                            <label class="custom-control-label"
                                                                for="gender3">Other</label>
                                                        </div>
                                                    </div>
                                                    @error('gender')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Describe Yourself</label>
                                            <div class="pass-group group-img">
                                                <textarea rows="4" class="form-control" id="introduction" name="introduction">{{ Auth::guard('vendor')->user()->introduction ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row socialmedia-info">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Facebook</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="fab fa-facebook-f"></i></span>
                                                        <input type="text" class="form-control"
                                                            placeholder="https://www.facebook.com/" name="facebook"
                                                            value="{{ Auth::guard('vendor')->user()->facebook ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Twitter</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="fab fa-twitter"></i></span>
                                                        <input type="text" class="form-control"
                                                            placeholder="https://twitter.com/" name="twitter"
                                                            value="{{ Auth::guard('vendor')->user()->twitter ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row socialmedia-info">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group formlast-input">
                                                    <label class="col-form-label">youtube</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i
                                                                class="fa-brands fa-youtube"></i></span>
                                                        <input type="text" class="form-control"
                                                            placeholder="https://www.youtube.com/" name="youtube"
                                                            value="{{ Auth::guard('vendor')->user()->youtube ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group formlast-input">
                                                    <label class="col-form-label">Instagram</label>
                                                    <div class="pass-group group-img">
                                                        <span class="lock-icon"><i class="fab fa-instagram"></i></span>
                                                        <input type="text" class="form-control"
                                                            placeholder="https://www.instagram.com/" name="instagram"
                                                            value="{{ Auth::guard('vendor')->user()->instagram ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary mt-4" type="submit"> Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <div class="profile-sidebar">

                            <div class="card">
                                <div class="card-header">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('vendor/update-current-password') }}" method="post"
                                        class="forms-sample">
                                        @csrf
                                        <div class="form-group">
                                            <label class="col-form-label">Current Password</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="feather-lock"></i></span>
                                                <input type="password" class="form-control current-pass-input"
                                                    placeholder="Password" id="current_password" name="current_password"
                                                    value="" onkeyup="checkCurrentPassword(this.value)"
                                                    autocomplete="off" autofocus="off">
                                                <span class="toggle-password feather-eye-off"
                                                    id="toggle-current-password"></span>
                                            </div>
                                            <p id="current_password_message"></p>
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">New Password</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="feather-lock"></i></span>
                                                <input type="password"
                                                    class="form-control pass-input @error('password') is-invalid @enderror"
                                                    id="new_password" name="password" placeholder="..............">
                                                <span class="toggle-password feather-eye-off" id="toggle-password"></span>
                                            </div>
                                            <p id="current_password_message"></p>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Confirm New Password</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="feather-lock"></i></span>
                                                <input type="password"
                                                    class="form-control confirm-pass-input @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation" autocomplete="password_confirmation"
                                                    placeholder="..............">
                                                <span class="toggle-password feather-eye-off"
                                                    id="confirm-toggle-password"></span>
                                            </div>
                                            <p id="current_password_message"></p>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <button class="btn btn-primary" type="submit"> Change Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.tiny.cloud/1/5kuebtof2f6mvl2hzc1ag686wjwtqdup6x44ytagtbw6expp/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
     tinymce.init({
       selector: '#introduction'
     });
   </script>
    <script>


        function delImage() {
            alert('run');
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
        // Hide flash messages after the specified duration
        $('.flash-message').delay($('.flash-message').data('duration')).fadeOut(500);
    });

        //Check current password
        function checkCurrentPassword(password) {

            $.ajax({
                url: "{{ url('vendor/check-current-password') }}",
                type: "post",
                data: {
                    'current_password': password
                },
                success: function(response) {
                    cl(response);
                    $("#current_password_message").empty();

                    if (response.status == 200) {
                        $("#current_password_message").html(
                            `<span class="text-success font-weight-bold">${response.message}</span>`)
                    } else {
                        $("#current_password_message").html(
                            `<span class="text-danger font-weight-bold">${response.message}</span>`)
                    }
                }
            });
        }
    </script>
@endpush
