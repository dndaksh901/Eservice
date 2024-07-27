@extends('layouts.main')

@section('content')
<style>
    .settings-upload-img,
    .settings-upload-img img {
        object-fit: cover;
        -o-object-fit: cover;
    }

    #occupation_id {
        padding: 14px 15px 14px 40px;
    }

    .input-group-text {
        padding: 0.75rem !important;
        background-color: #e9ecef !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.375rem;
    }

    .settings-upload-img,
    .settings-upload-img img {
        margin-right: 2rem;
    }

    div.preview-image-div {
        display: flex;
        flex-wrap: wrap;
    }

    .preview-image {
        width: 50px;
        height: 50px;
    }

    a.link-image {
        z-index: 5;
    }

    button.close {
        z-index: 6;
        border: none;
    }

    span.del-btn {
        color: white;
        border: 1px solid #a5a3a3;
        border-radius: 50%;
        padding: 0px 8px;
        position: absolute;
        background: #00000087;
        top: 45px;
        right: 34px;
    }

    img.profile-side-image {
        position: fixed;
        max-width: 41.5%;
        width: 100%;
    }


    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: #ffffff;
        background: #2196f3;
        padding: 3px 7px;
        border-radius: 3px;
    }

    .bootstrap-tagsinput {
        width: 100%;
    }

    /*
             * bootstrap-tagsinput v0.8.0
             *
             */

    .bootstrap-tagsinput {
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        display: inline-block;
        padding: 4px 6px;
        color: #555;
        vertical-align: middle;
        border-radius: 4px;
        max-width: 100%;
        line-height: 22px;
        cursor: text;
    }

    .bootstrap-tagsinput input {
        border: none;
        box-shadow: none;
        outline: none;
        background-color: transparent;
        padding: 0 6px;
        margin: 0;
        width: auto;
        max-width: inherit;
    }

    .bootstrap-tagsinput.form-control input::-moz-placeholder {
        color: #777;
        opacity: 1;
    }

    .bootstrap-tagsinput.form-control input:-ms-input-placeholder {
        color: #777;
    }

    .bootstrap-tagsinput.form-control input::-webkit-input-placeholder {
        color: #777;
    }

    .bootstrap-tagsinput input:focus {
        border: none;
        box-shadow: none;
    }

    .bootstrap-tagsinput .tag {
        margin-right: 2px;
        color: white;
    }

    .bootstrap-tagsinput .tag [data-role="remove"] {
        margin-left: 8px;
        cursor: pointer;
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:after {
        content: "x";
        padding: 0 2px;
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:hover {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .bootstrap-tagsinput .tag [data-role="remove"]:hover:active {
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    }
</style>

<div class="breadcrumb-bar">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">Profession</h2>
                <nav aria-label="breadcrumb" class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profession</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="dashboard-content">
    <div class="container">
        <div>
            @include('includes.tabs')
        </div>
        <div class="profile-content">
            <div class="row dashboard-info">
                <div class="col-lg-12">
                    <div class="card dash-cards">
                        <div class="card-header">
                            <h4>Profession Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="profile-photo">
                                <div class="profile-img">
                                    @php $avatar=Auth::guard('vendor')->user()->avatar ?? 'avatar.jpg'; @endphp
                                    <div class="settings-upload-img">
                                        <img src="{{ asset('vendor/vendor_image/' . $avatar) }}" alt="profile">
                                    </div>
                                    <div>
                                        <p><strong>Hello, {{ Str::title(Auth::guard('vendor')->user()->name) }}</strong></p>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-form">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="list-unstyled">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ url('vendor/profession') }}" method="post" class="forms-sample" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        @if (session()->has('error'))
                                            <div class="col-12 alert alert-danger alert-dismissible fade show" role="alert">
                                                <strong>{{ session()->get('error') }}</strong>
                                            </div>
                                        @endif
                                        @if (session()->has('success'))
                                            <div class="col-12 alert alert-success flash-message" data-duration="5000">
                                                <strong>{{ session()->get('success') }}</strong>
                                            </div>
                                        @endif
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Occupation<span class="text-danger"><sup>*</sup></span></label>
                                                <div class="pass-group group-img">
                                                    <span class="lock-icon"><i class="feather-user"></i></span>
                                                    <select class="js-example-basic-single form-control" name="occupation_id" id="occupation_id">
                                                        @foreach ($occupations as $occupation)
                                                            <option value="{{ $occupation->id }}" {{ isset($profile) && $profile->occupation_id == $occupation->id ? 'selected' : '' }}>
                                                                {{ $occupation->occupation_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('occupation_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Experience (Year/Month)</label>
                                                <div class="d-flex">
                                                    <label class="sr-only" for="experience_year">Experience Year</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Year</div>
                                                        </div>
                                                        <input type="number" class="form-control mr-2" name="experience_year" min="0" max="100" value="{{ $profile->experience_year ?? '0' }}">
                                                    </div>
                                                    <label class="sr-only" for="experience_month">Experience Month</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">Month</div>
                                                        </div>
                                                        <input type="number" class="form-control mr-2" name="experience_month" min="0" max="11" value="{{ $profile->experience_month ?? '0' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group form-outline">
                                                <label for="name">Full Address<span class="text-danger"><sup>*</sup></span></label>
                                                <input class="form-control" name="address" id="autocomplete"value="{{ $profile->address ?? '' }}" placeholder = "full address">
                                                <input type="hidden" class="form-control" name="latitude" id="latitude" value="{{ $profile->latitude ?? '' }}" readonly>
                                                <input type="hidden" class="form-control" name="longitude" id="longitude" value="{{ $profile->longitude ?? '' }}" readonly>
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label">Price Per Hour</label>
                                                <div class="pass-group group-img">
                                                    <span class="lock-icon"><i class="fa-solid fa-money-bill-1"></i></span>
                                                    <input type="text" class="form-control" name="price_per_hour" value="{{ $profile->price_per_hour ?? '' }}">
                                                </div>
                                                @error('price_per_hour')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="services">Our Services</label>
                                            <div class="mb-3">

                                                <input class="form-control" type="text" data-role="tagsinput"
                                                    name="services" value={{ $profile->services ?? '' }}>
                                                <small>*Enter max 10 limit</small>
                                                @if ($errors->has('services'))
                                                    <span class="text-danger">{{ $errors->first('services') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="profile_description">Profile Description</label>
                                            <div class="mb-3">
                                                <textarea class="form-control" placeholder="Enter your description here" name="profile_description" id="profile_description" rows="2">{{ $profile->profile_description ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label for="file">Works Image</label>
                                                <input type="file" class="form-control" id="file-input"
                                                    onchange="loadPreview(this)" name="avatar[]" accept="image/*"
                                                    multiple>
                                                <small class="text-mute">Note*: Max. 5 Images will be
                                                    uploaded(formats png, jpg, jpeg) </small>
                                                @error('avatar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <div id="preview-output"></div>
                                                <div id="error-preview-image"></div>
                                                <br>

                                            </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
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
<!-- Include Google Maps JavaScript API -->
@push('js')
<script src="https://cdn.tiny.cloud/1/5kuebtof2f6mvl2hzc1ag686wjwtqdup6x44ytagtbw6expp/tinymce/6/tinymce.min.js"
referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#profile_description'
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"></script>
<script>
(function() {
    navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        },
        function(error) {
            console.log("The Locator was denied. :(")
        })
})();

$('input[name="tags"]').tagsinput({
    maxTags: 10
});

$(document).ready(function() {
    // Hide flash messages after the specified duration
    $('.flash-message').delay($('.flash-message').data('duration')).fadeOut(500);
});

function deleteImage(id) {
    $.ajax({
        url: "{{ url('vendor/deleteProfileImage') }}/" + id,
        type: "get",
        success: function(data) {
            $('#error-preview-image').empty();
            if (data.status == 200) {
                previewImage();
            } else {
                $('#error-preview-image').text(data.message);
            }
        }
    })
}

function previewImage() {
    $.ajax({
        url: "{{ url('vendor/previewImage') }}",
        type: "get",
        success: function(data) {
            $('#preview-output').empty();
            if (data.status == 200) {
                let images = data.message;
                let previewImageDiv = '';

                images.forEach((val, ind) => {
                    previewImageDiv += `

                <div class="card m-2">
                   <a href="{{ asset('vendor/profile_image/${val.profile_image}') }}" target="_blank" class="link-image"> <img class="card-img-top" src="{{ asset('vendor/profile_image/${val.profile_image}') }}" alt="${val.profile_image}" style="width:100px;height:100px"></a>
                    <button type="button" class="close" aria-label="Close" onclick="deleteImage(${val.id})">
<span aria-hidden="true" class="del-btn">&times;</span>
</button>
                    </div>

            `
                });

                $('#preview-output').append(
                    `<div class="preview-image-div my-2">${previewImageDiv}</div>`);
            } else {
                $('#preview-output').append(data.message);
            }
        }


    })
}

var $disabledResults = $(".js-example-basic-single");
$disabledResults.select2({
    width: '100%'
});

function stateChange(selectedValue) {
    //make the ajax call
    $.ajax({
        url: '{{ url('city-by-state') }}' + "/" + selectedValue,
        type: 'get',
        success: function(data) {
            console.log(data);
            $('select[name="city_id"]').empty();
            if (data.length > 0) {
                $.each(data, function(id, locations) {
                    var capitalizedCityName = locations.name.charAt(0).toUpperCase() + locations
                        .name.slice(1);

                    $('select[name="city_id"]').append(
                        $("<option></option>")
                        .attr("value", locations.id)
                        .attr("selected", locations.id == "{{ $profile->city_id ?? '' }}" ?
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
// image preview
$(document).ready(function(e) {
    let state = $('#state_id').val();
    stateChange(state);
    previewImage();

    function loadPreview(input) {
        var data = $(input)[0].files; //this file data
        $.each(data, function(index, file) {
            if (/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)) {
                var fRead = new FileReader();
                fRead.onload = (function(file) {
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target
                            .result); //create image thumb element
                        $('#thumb-output').append(img);
                    };
                })(file);
                fRead.readAsDataURL(file);
            }
        });
    }
});
</script>

{{-- Google map autocomplte locaiton script --}}
<script>
    let autocompleteInput = document.getElementById('autocomplete');
    let autocomplete;
    let userSelectedAddress = false; // Flag to track if the user selected an address

    function initializeprofile() {
        autocomplete = new google.maps.places.Autocomplete(autocompleteInput, {
            types: ['geocode']
        });

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();

            if (!place.geometry) {
                console.log("No details available for input: '" + place.name + "'");
                return;
            }

            // Set the address field to the formatted address
            autocompleteInput.value = place.formatted_address;

            // Set latitude and longitude fields
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

            // Set flag to true as user has selected an address
            userSelectedAddress = true;

            // Optionally, extract other components if needed
        });

        // Optional: Clear flag when focus is lost if it's invalid (e.g., if it was not set by autocomplete)
        autocompleteInput.addEventListener('focus', function() {
            autocompleteInput.disabled = false;
            userSelectedAddress = false; // Reset the flag when user starts typing
        });

        // Reset flag on focus out if the address was not selected
        autocompleteInput.addEventListener('blur', function() {
            if (!userSelectedAddress) {
                autocompleteInput.classList.add('is-invalid');
                document.getElementById('address-error').innerText = 'Please select a valid address from the suggestions.';
            } else {
                autocompleteInput.classList.remove('is-invalid');
                document.getElementById('address-error').innerText = '';
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initializeprofile);
</script>


@endpush
