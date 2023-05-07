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
    img.profile-side-image{
        position: fixed;
        max-width: 41.5%;
        width: 100%;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
    color: #fff;
    border-color: #097953;
    background-color: #097953;
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
        <div class="col-lg-6 col-md-12 col-sm-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Vendor Personal Information</h4>
              <form action="{{ url('vendor/update-personal_detail') }}" method="post" class="forms-sample" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" readonly value="{{ Auth::guard('vendor')->user()->email }}">
                </div>

                <div class="form-group">
                    <label for="exampleInputUsername1">Username</label>
                    <input type="text" class="form-control" readonly value="{{ Auth::guard('vendor')->user()->username }}">
                </div>

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control"  name="name" value="{{ Auth::guard('vendor')->user()->name }}">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="confirm_password">Mobile</label>
                  <input type="number" class="form-control" name="mobile" value="{{ Auth::guard('vendor')->user()->mobile }}">
                  <p id="current_password_message"></p>
                  @error('mobile')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="confirm_password">Date of Birth</label>
                  <input type="date" class="form-control" name="dob" value="{{ Auth::guard('vendor')->user()->dob }}">
                  @error('dob')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
            <label for="gender">Gender</label>
            <br>
                    <!-- Default inline 1-->
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="gender1" name="gender" value="male" {{ Auth::guard('vendor')->user()->gender == 'male' ?'checked' : '' }}>
                <label class="custom-control-label" for="gender1">Male</label>
            </div>

            <!-- Default inline 2-->
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="gender2" name="gender" value="female" {{ Auth::guard('vendor')->user()->gender == 'female' ?'checked' : '' }}>
                <label class="custom-control-label" for="gender2">Female</label>
            </div>

            <!-- Default inline 3-->
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="gender3" name="gender" value="other" {{ Auth::guard('vendor')->user()->gender == 'other' ?'checked' : '' }}>
                <label class="custom-control-label" for="gender3">Other</label>
            </div>
        @error('gender')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
                </div>

                <div class="form-group">
                    <label for="file">Profile Image</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                    @error('avatar')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror

                    <div class="col-md-12 my-2">
                        @php $avatar=Auth::guard('vendor')->user()->avatar ?? 'avatar.jpg'; @endphp
                        <a href="{{ asset('vendor/vendor_image/'.$avatar) }}" target="_blank" title="view"><img id="preview-image-before-upload" src="{{ asset('vendor/vendor_image/'.$avatar) }}"
                            alt="preview image" style="max-height: 150px;"></a>
                    </div>
                  </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div><img src="{{ asset('vendor/personal-page.png')}}" alt="personal-page" class="img-fluid profile-side-image"></div>
        </div>
      </div>
    </div>

@endsection

@push('script')

{{-- image preview --}}
<script type="text/javascript">

var $disabledResults = $(".js-example-basic-single");
$disabledResults.select2();

    $(document).ready(function (e) {


       $('#avatar').change(function(){

        let reader = new FileReader();

        reader.onload = (e) => {

          $('#preview-image-before-upload').attr('src', e.target.result);
        }

        reader.readAsDataURL(this.files[0]);

       });

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
