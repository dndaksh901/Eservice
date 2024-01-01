@extends('admin.layout.layout')

@section('content')
    <style>
        /* body {
                    margin: 0;
                    padding-top: 40px;
                    color: #2e323c;
                    background: #f5f6fa;
                    position: relative;
                    height: 100%;
                } */

        .account-settings .user-profile {
            margin: 0 0 1rem 0;
            padding-bottom: 1rem;
            text-align: center;
        }

        .account-settings .user-profile .user-avatar {
            margin: 0 0 1rem 0;
        }

        .account-settings .user-profile .user-avatar img {
            width: 90px;
            height: 90px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }

        .account-settings .user-profile h5.user-name {
            margin: 0 0 0.5rem 0;
        }

        .account-settings .user-profile h6.user-email {
            margin: 0;
            font-size: 0.8rem;
            font-weight: 400;
            color: #9fa8b9;
        }

        .account-settings .about {
            margin: 2rem 0 0 0;
            text-align: center;
        }

        .account-settings .about h5 {
            margin: 0 0 15px 0;
            color: #007ae1;
        }

        .account-settings .about p {
            font-size: 0.825rem;
        }

        .form-control {
            border: 1px solid #cfd1d8;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: .825rem;
            background: #ffffff;
            color: #2e323c;
        }

        .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
        }
    </style>
    <div class="container">
        <h2>Vendor Detail </h2>
        <p>Status: {!! $vendor->status == 0
            ? '<span class="text-danger font-weight-bold">Inactive</span>'
            : '<span class="text-success font-weight-bold">Active</span>' !!}</p>
        <div class="container">
            <div class="row gutters">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="account-settings">
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        @if (isset($vendor['avatar']))
                                            <img id="profileImage"
                                                src="{{ asset('vendor/vendor_image/' . $vendor['avatar']) }}"
                                                alt="{{ $vendor['name'] }}">
                                        @else
                                            <img id="profileImage" src="{{ asset('vendor/vendor_image/avatar.jpg') }}"
                                                alt="Avatar vendor">
                                        @endif

                                    </div>
                                    <form action="{{ url('/admin/vendor-image-update/' . $vendor['id']) }}" method="post"
                                        enctype="multipart/form-data" id="uploadForm">
                                        @csrf
                                        <input type="file" name="avatar" id="avatar" class="form-control">
                                        <div class="d-flex justify-content-around m-3">

                                            <button type="submit" id="uploadBtn" class="btn btn-primary"
                                                title="Upload image"><i class="icon-upload"></i></button>
                                            <button type="button" id="deleteBtn" class="btn btn-danger"
                                                title="Delete image"><i class="icon-trash"></i></button>
                                        </div>
                                    </form>

                                    <!-- Add a button to delete the profile image -->

                                    <h5 class="user-name">{{ $vendor['name'] ?? '' }}</h5>
                                    <h6 class="user-email">{{ $vendor['email'] ?? '' }}</h6>
                                    <h6 class="user-name"><b>Occupation :</b>
                                        {{ $vendor['profile']['occupation']['occupation_name'] ?? '' }}</h6>
                                    <h6 class="user-name"><b>Exp :</b> {{ $vendor['profile']['experience_year'] ?? '0' }}
                                        years {{ $vendor['profile']['experience_month'] ?? '0' }} Month</h6>
                                    <h6 class="user-name"><b>Website :</b> <a
                                            href="{{ $vendor['profile']['website_url'] ?? '' }}"
                                            target="_blank">{{ $vendor['profile']['website_url'] ?? '' }}</a></h6>

                                </div>

                                @if (isset($vendor['introduction']))
                                    <div class="about">
                                        <h5>About</h5>
                                        {{-- <textarea rows="4" class="form-control" id="introduction" name="introduction">{{ $vendor->introduction ?? '' }}</textarea> --}}
                                        <p>{{ $vendor->introduction ?? '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
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
                    <form action="{{ url('/admin/vendor-update/' . $vendor['id']) }}" method="post">
                        @csrf
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="mb-2 text-primary">Personal Details</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="fullname">Name</label>
                                            <input type="text" class="form-control" id="fullname"
                                                placeholder="Enter full name" name="name"
                                                value="{{ $vendor['name'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter Username" name="username"
                                                value="{{ $vendor['username'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Enter email ID" name="email"
                                                value="{{ $vendor['email'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="mobile"
                                                placeholder="Enter phone number" value="{{ $vendor['mobile'] ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" class="form-control" name="dob"
                                                value="{{ $vendor['dob'] ?? '' }} }}" id="dob" required>

                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="gender">Gender</label><br>
                                            <select class="form-control" aria-label=".form-select-lg example"
                                                name="gender" class="form-control" id="gender">
                                                <option selected disabled>Select Gender</option>
                                                <option value="male" {{ $vendor->gender == 'male' ? 'selected' : '' }}>
                                                    Male
                                                </option>
                                                <option value="female"
                                                    {{ $vendor->gender == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="other" {{ $vendor->gender == 'other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Describe Yourself</label>
                                            <div class="pass-group group-img">
                                                <textarea rows="4" class="form-control" id="profile_description" name="profile_description">{{ $vendor->profile->profile_description ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="mt-3 mb-2 text-primary">Social Links</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Facebook</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="fab fa-facebook-f"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="https://www.facebook.com/" name="facebook"
                                                    value="{{ $vendor->facebook ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="col-form-label">Twitter</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="fab fa-twitter"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="https://twitter.com/" name="twitter"
                                                    value="{{ $vendor->twitter ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group formlast-input">
                                            <label class="col-form-label">youtube</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="fa-brands fa-youtube"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="https://www.youtube.com/" name="youtube"
                                                    value="{{ $vendor->youtube ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group formlast-input">
                                            <label class="col-form-label">Instagram</label>
                                            <div class="pass-group group-img">
                                                <span class="lock-icon"><i class="fab fa-instagram"></i></span>
                                                <input type="text" class="form-control"
                                                    placeholder="https://www.instagram.com/" name="instagram"
                                                    value="{{ $vendor->instagram ?? '' }}">
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <h6 class="mt-3 mb-2 text-primary">Address</h6>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="address">address</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Enter Address"
                                                value="{{ $vendor->profile->address ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="admin_type">State<span
                                                    class="text-danger"><sup>*</sup></span></label>
                                            <select class="js-example-basic-single form-control" name="state_id"
                                                id="state_id" onchange="stateChange(this.value)">
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ isset($profile) && $vendor->profile->state_id == $state->id ? 'selected' : '' }}>
                                                        {{ ucfirst($state->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="admin_type">City<span
                                                    class="text-danger"><sup>*</sup></span></label>
                                            <select class="js-example-basic-single form-control" name="city_id"
                                                id="city_id">
                                                <option>select state</option>
                                                {{-- @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ isset($profile) && $profile->city_id == $city->id ? 'selected' : '' }}>
                                                    {{ $city->name }}</option>
                                            @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="zIp">Zip Code</label>
                                            <input type="text" class="form-control" id="zIp"
                                                placeholder="Zip Code" name="pincode"
                                                value="{{ $vendor->profile->pincode ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="text-right">
                                            <button type="button" id="submit" name="submit"
                                                class="btn btn-secondary">Cancel</button>
                                            <button type="submit" id="submit" name="submit"
                                                class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.tiny.cloud/1/5kuebtof2f6mvl2hzc1ag686wjwtqdup6x44ytagtbw6expp/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#profile_description'
        });
    </script>

    <script>
        function stateChange(selectedValue) {
            //make the ajax call
            $.ajax({
                url: '{{ url('city-by-state') }}' + "/" + selectedValue,
                type: 'get',
                success: function(data) {

                    $('select[name="city_id"]').empty();
                    if (data.length > 0) {
                        $.each(data, function(id, locations) {
                            var capitalizedCityName = locations.name.charAt(0).toUpperCase() + locations
                                .name.slice(1);

                            $('select[name="city_id"]').append(
                                $("<option></option>")
                                .attr("value", locations.id)
                                .attr("selected", locations.id ==
                                    "{{ $vendor->profile->city_id ?? '' }}" ?
                                    true : false)
                                .text(capitalizedCityName)
                            );
                        });
                    } else {
                        $('select[name="city_id"]').append(`<option>No City found</option>`);
                    }
                }
            });
        }
        $(document).ready(function() {
            let state_id = $('#state_id').val();
            stateChange(state_id);
            $('#uploadForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                alert('test');
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response.success);

                        // Update the displayed image on success
                        $('#profileImage').attr('src', "{{ asset('vendor/vendor_image/') }}" +
                            '/' + response.avatar);

                        // You can also update other UI elements or show a success message
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle errors if needed
                    }
                });
            });

            // Add an event listener for the delete button
            $('#deleteBtn').click(function() {
                dangerClick();
                die;
                $.ajax({
                    url: '/admin/delete-profile-image/{{ $vendor->vendor_id }}',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        // alert(response.success);

                        // Update the displayed image to a default or placeholder image
                        $('#profileImage').attr('src',
                            "{{ asset('vendor/vendor_image/avatar.jpg') }}" + '/' +
                            response.avatar);

                        // You can also update other UI elements or show a success message
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert(response.error);
                    }
                });
            });

        });


        var successClick = function() {
            $.notify({
                // options
                title: '<strong>Success</strong>',
                message: "<br>Facendo click su questa notifica, si aprirà la pagina di Robert McIntosh, autore del plugin <em><strong>notify.js</strong></em>",
                icon: 'glyphicon glyphicon-ok',
                url: 'https://github.com/mouse0270/bootstrap-notify',
                target: '_blank'
            }, {
                // settings
                element: 'body',
                //position: null,
                type: "success",
                //allow_dismiss: true,
                //newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutRight'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var infoClick = function() {
            $.notify({
                // options
                title: '<strong>Info</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-info-sign',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "info",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated bounceInDown',
                    exit: 'animated bounceOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var warningClick = function() {
            $.notify({
                // options
                title: '<strong>Warning</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-warning-sign',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "warning",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated bounceIn',
                    exit: 'animated bounceOut'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var dangerClick = function() {
            $.notify({
                // options
                title: '<strong>Danger</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-remove-sign',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "danger",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated flipInY',
                    exit: 'animated flipOutX'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var primaryClick = function() {
            $.notify({
                // options
                title: '<strong>Primary</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-ruble',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "success",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated lightSpeedIn',
                    exit: 'animated lightSpeedOut'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var defaultClick = function() {
            $.notify({
                // options
                title: '<strong>Default</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-ok-circle',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "warning",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated rollIn',
                    exit: 'animated rollOut'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }

        var linkClick = function() {
            $.notify({
                // options
                title: '<strong>Link</strong>',
                message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
                icon: 'glyphicon glyphicon-search',
            }, {
                // settings
                element: 'body',
                position: null,
                type: "danger",
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 1031,
                delay: 3300,
                timer: 1000,
                url_target: '_blank',
                mouse_over: null,
                animate: {
                    enter: 'animated zoomInDown',
                    exit: 'animated zoomOutUp'
                },
                onShow: null,
                onShown: null,
                onClose: null,
                onClosed: null,
                icon_type: 'class',
            });
        }
    </script>
@endpush
