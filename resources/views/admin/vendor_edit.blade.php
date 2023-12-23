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
        <p>Status: {!! $vendor->status == 0 ? '<span class="text-danger font-weight-bold">Inactive</span>' : '<span class="text-success font-weight-bold">Active</span>'  !!}</p>
        <div class="container">
            <div class="row gutters">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="account-settings">
                                <div class="user-profile">
                                    <div class="user-avatar">
                                        @if(isset($vendor['avatar']))
                                        <img id="profileImage" src="{{ asset('vendor/vendor_image/' . $vendor['avatar']) }}" alt="{{$vendor['name']}}">
                                    @else
                                        <img id="profileImage" src="{{ asset('vendor/vendor_image/avatar.jpg') }}" alt="Avatar vendor">
                                    @endif

                                    </div>
                                    <form action="{{ url('/admin/vendor-image-update/'.$vendor['id']) }}" method="post" enctype="multipart/form-data" id="uploadForm">
                                        @csrf
                                        <input type="file" name="avatar" id="avatar" class="form-control">
                                        <div class="d-flex justify-content-around m-3">

                                            <button type="submit" id="uploadBtn" class="btn btn-primary" title="Upload image"><i class="icon-upload"></i></button>
                                            <button type="button" id="deleteBtn" class="btn btn-danger" title="Delete image"><i class="icon-trash"></i></button>
                                        </div>
                                    </form>

                                    <!-- Add a button to delete the profile image -->

                                    <h5 class="user-name">{{ $vendor['name'] ?? '' }}</h5>
                                    <h6 class="user-email">{{ $vendor['email'] ?? '' }}</h6>
                                </div>
                                @if(isset($vendor['profile']['profile_description']))
                                <div class="about">
                                    <h5>About</h5>
                                    <p>{{ $vendor['profile']['profile_description'] ?? '' }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
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
                                            placeholder="Enter phone number"
                                            value="{{ $vendor['mobile'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="website">Website URL</label>
                                        <input type="url" class="form-control" id="website" name="website_url"
                                            placeholder="Website url" value="{{ $vendor['profile']['website_url'] ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="gender">Gender</label><br>
                                        <select class="form-control" aria-label=".form-select-lg example" name="gender" class="form-control" id="gender">
                                            <option selected disabled>Select Gender</option>
                                            <option value="male"  {{ $vendor->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $vendor->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="other"  {{ $vendor->gender == 'other' ? 'selected' : '' }}>Other</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mt-3 mb-2 text-primary">Address</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="Street">Street</label>
                                        <input type="name" class="form-control" id="Street"
                                            placeholder="Enter Street">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="ciTy">City</label>
                                        <input type="name" class="form-control" id="ciTy" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="sTate">State</label>
                                        <input type="text" class="form-control" id="sTate" placeholder="Enter State">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="zIp">Zip Code</label>
                                        <input type="text" class="form-control" id="zIp" placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="text-right">
                                        <button type="button" id="submit" name="submit"
                                            class="btn btn-secondary">Cancel</button>
                                        <button type="button" id="submit" name="submit"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
 <script>
    $(document).ready(function(){
        $('#uploadForm').submit(function(e){
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
                success: function(response){
                    alert(response.success);

                    // Update the displayed image on success
                    $('#profileImage').attr('src', "{{ asset('vendor/vendor_image/') }}" + '/' + response.avatar);

                    // You can also update other UI elements or show a success message
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle errors if needed
                }
            });
        });

           // Add an event listener for the delete button
           $('#deleteBtn').click(function(){
            dangerClick ();
            die;
            $.ajax({
                url: '/admin/delete-profile-image/{{ $vendor->vendor_id }}',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    // alert(response.success);

                    // Update the displayed image to a default or placeholder image
                    $('#profileImage').attr('src', "{{ asset('vendor/vendor_image/avatar.jpg') }}" + '/' + response.avatar);

                    // You can also update other UI elements or show a success message
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert(response.error);
                }
            });
        });

    });


    var successClick = function(){
  $.notify({
	// options
	title: '<strong>Success</strong>',
	message: "<br>Facendo click su questa notifica, si aprirà la pagina di Robert McIntosh, autore del plugin <em><strong>notify.js</strong></em>",
  icon: 'glyphicon glyphicon-ok',
	url: 'https://github.com/mouse0270/bootstrap-notify',
	target: '_blank'
},{
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

var infoClick = function(){
  $.notify({
	// options
	title: '<strong>Info</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-info-sign',
},{
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

var warningClick = function(){
  $.notify({
	// options
	title: '<strong>Warning</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-warning-sign',
},{
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

var dangerClick = function(){
  $.notify({
	// options
	title: '<strong>Danger</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-remove-sign',
},{
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

var primaryClick = function(){
  $.notify({
	// options
	title: '<strong>Primary</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-ruble',
},{
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

var defaultClick = function(){
  $.notify({
	// options
	title: '<strong>Default</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-ok-circle',
},{
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

var linkClick = function(){
  $.notify({
	// options
	title: '<strong>Link</strong>',
	message: "<br>Lorem ipsum Reference site about Lorem Ipsum, giving information on its origins, as well as a random Lipsum.",
  icon: 'glyphicon glyphicon-search',
},{
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
