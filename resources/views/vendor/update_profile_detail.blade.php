@extends('vendor.layout.layout')

@section('links')

 <!-- Select2 -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
 <!-- endSelect2 -->

@endsection

@section('content')

<style>
    .select2-container--default .select2-selection--single {
        height: auto;
        padding: 8px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        top: 10px;
        right: 4px;
    }

    .select2-container .select2-selection--single .select2-selection__rendered {
        padding-left: 15px;
    }
    div.preview-image-div{
        display: flex;
        flex-wrap: wrap;
    }
    .preview-image{
        width:50px;
        height: 50px;
    }
    a.link-image{
        z-index: 5;
    }
    button.close{
        z-index: 6;
    }
    span.del-btn {
        color: white;
        border: 1px solid #a5a3a3;
        border-radius: 50%;
        padding: 2px 8px;
        position: absolute;
        background: black;
        top: 45px;
        right: 34px;
    }
    img.profile-side-image{
        position: fixed;
        max-width: 41.5%;
        width: 100%;
    }
</style>

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())

                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                    <li class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error :</strong> {{$error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </li>
                    @endforeach

                </ul>

                @endif
                @if(session()->has('error'))
                    <ul class="list-unstyled">
                        <li class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </li>
                    </ul>
                @endif
                @if(session()->has('success'))
                    <ul class="list-unstyled">
                        <li class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </li>
                    </ul>

                @endif
            </div>
        </div>

      <div class="row">
        <div class="col-lg-6 col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Vendor Personal Information</h4>
              <form action="{{ url('vendor/update-profile-detail') }}" method="post" class="forms-sample" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="admin_type">Occupation<span class="text-danger"><sup>*</sup></span></label>
                    <select class="js-example-basic-single form-control" name="occupation_id">
                        @foreach ($occupations as $occupation )
                            <option value="{{ $occupation->id }}" {{ (isset($profile) && $profile->occupation_id == $occupation->id) ? 'selected' : '' }}>{{ $occupation->occupation_name }}</option>
                        @endforeach
                      </select>
                </div>

                <div class="form-group">
                    <label for="experience">Experience (Year/Month)</label>
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
                <div class="form-group">
                    <label for="priceperhour">Price Per Hour (INR)</label>
                    <input type="text" class="form-control" name="price_per_hour" value="{{ $profile->price_per_hour ?? '' }}">
                </div>
                <div  class="form-group form-outline">
                    <label for="name">Address<span class="text-danger"><sup>*</sup></span></label>
                    <textarea class="form-control" name="address" id="address" rows="5" value="{{ $profile->address ?? '' }}">{{ $profile->address ?? ''}}</textarea>
                    @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="admin_type">State<span class="text-danger"><sup>*</sup></span></label>
                    <select class="js-example-basic-single form-control" name="state_id" id="state_id" onchange="stateChange(this.value)" >
                        @foreach ($states as $state )
                            <option value="{{ $state->id }}" {{ isset($profile) && $profile->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                        @endforeach
                      </select>
                </div>

                <div class="form-group">
                    <label for="admin_type">City<span class="text-danger"><sup>*</sup></span></label>
                    <select class="js-example-basic-single form-control" name="city_id" id="city_id">
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ isset($profile) && $profile->city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                      </select>
                </div>

                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" class="form-control" name="pincode" value="{{ $profile->pincode ?? '' }}">
                </div>


                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" class="form-control" name="latitude" id="latitude" value="{{ $profile->pincode ?? '' }}" readonly>
                </div>
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" class="form-control" name="longitude" id="longitude" value="{{ $profile->pincode ?? '' }}" readonly>
                </div>

                <div class="form-group">
                    <label for="profile_description">Profile Description</label>
                    <textarea class="form-control" id="profile_description" rows="3" name="profile_description">{{ $profile->profile_description ?? '' }}</textarea>
                </div>


                <div class="form-group">
                    <label for="file">Works Image</label>
                    <input type="file" class="form-control" id="file-input" onchange="loadPreview(this)"  name="avatar[]" accept="image/*" multiple>
                    <small class="text-mute">Note*: Max. 5 Images will be uploaded(format) </small>
                    @error('avatar')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                       <div id="preview-output"></div>
                       <div id="error-preview-image"></div>
                       <br>


                    {{-- <div class="col-md-12 my-2">
                        @php $avatar=Auth::guard('vendor')->user()->avatar ?? 'avatar.jpg'; @endphp
                        <a href="{{ asset('vendor/vendor_image/'.$avatar) }}" target="_blank" title="view"><img id="preview-image-before-upload" src="{{ asset('vendor/vendor_image/'.$avatar) }}"
                            alt="preview image" style="max-height: 150px;"></a>
                    </div> --}}
                  </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div><img src="{{ asset('vendor/profile-page.png')}}" alt="profile-image" class="img-fluid profile-side-image"></div>
        </div>
      </div>
    </div>

@endsection

@push('script')


<script type="text/javascript">

(function () {
    navigator.geolocation.getCurrentPosition(function (position) {
       document.getElementById("latitude").value = position.coords.latitude;
       document.getElementById("longitude").value =position.coords.longitude;
    },
    function (error) {
        console.log("The Locator was denied. :(")
    })
})();

function deleteImage(id){
  $.ajax({
    url:"{{ url('vendor/deleteProfileImage') }}/"+id,
    type:"get",
    success:function(data){
        $('#error-preview-image').empty();
        if(data.status == 200){
             previewImage();
        }else{
            $('#error-preview-image').text(data.message);
        }
    }
  })
}

 function previewImage(){
    $.ajax({
        url:"{{ url('vendor/previewImage') }}",
        type:"get",
        success:function(data){
            $('#preview-output').empty();
            if(data.status == 200){
                let images = data.message;
                let previewImageDiv = '';

                images.forEach( (val,ind) => {
                    previewImageDiv += `

                        <div class="card m-2">
                           <a href="{{ asset('vendor/profile_image/${val.profile_image}') }}" target="_blank" class="link-image"> <img class="card-img-top" src="{{ asset('vendor/profile_image/${val.profile_image}') }}" alt="${val.profile_image}" style="width:100px;height:100px"></a>
                            <button type="button" class="close" aria-label="Close" onclick="deleteImage(${val.id})">
  <span aria-hidden="true" class="del-btn">&times;</span>
</button>
                            </div>

                    `
                });

                $('#preview-output').append(`<div class="preview-image-div my-2">${previewImageDiv}</div>`);
            }else{
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
        url: '{{url("city-by-state")}}'+ "/"+selectedValue,
        type: 'get',
        success: function(data) {
            // console.log(data);
            $('select[name="city_id"]').empty();
            if(data.length >0){
                $.each(data,function(id,locations){
              $('select[name="city_id"]').append($("<option></option>").attr("value",locations.id).text(locations.name));
             });
            }
            else{
                $('select[name="city_id"]').append(`<option>No City found</option>`);
            }
        }
    });
}
 // image preview
$(document).ready(function (e) {
    let state = $('#state_id').val();
    stateChange(state);
    previewImage();

    //    $('#avatar').change(function(){

    //     let reader = new FileReader();

    //     reader.onload = (e) => {

    //       $('#preview-image-before-upload').attr('src', e.target.result);
    //     }

    //     reader.readAsDataURL(this.files[0]);



    function loadPreview(input){
       var data = $(input)[0].files; //this file data
       $.each(data, function(index, file){
           if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
               var fRead = new FileReader();
               fRead.onload = (function(file){
                   return function(e) {
                       var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image thumb element
                       $('#thumb-output').append(img);
                   };
               })(file);
               fRead.readAsDataURL(file);
           }
       });
   }
    });


</script>
  <script>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Check current password
        function checkCurrentPassword(password){

             $.ajax({
                url:"{{ url('admin/check-current-password') }}",
                type:"post",
                data:{
                   'current_password' : password
                },
                success:function(response){
                    cl(response);
                    $("#current_password_message").empty();

                    if(response.status == 200){
                        $("#current_password_message").html(`<span class="text-success font-weight-bold">${response.message}</span>`)
                    }else{
                        $("#current_password_message").html(`<span class="text-danger font-weight-bold">${response.message}</span>`)
                    }
                }
             });
        }

  </script>
@endpush
