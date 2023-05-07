@extends('admin.layout.layout')

@section('content')

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
        <div class="col-md-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Admin Details</h4>
              <form action="{{ url('admin/update-admin-detail') }}" method="post" class="forms-sample" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" readonly value="{{ Auth::guard('admin')->user()->email }}">
                </div>

                <div class="form-group">
                    <label for="exampleInputUsername1">Username</label>
                    <input type="text" class="form-control" readonly value="{{ Auth::guard('admin')->user()->username }}">
                </div>

                <div class="form-group">
                    <label for="admin_type">Admin Type</label>
                    <input type="text" class="form-control" readonly value="{{ Auth::guard('admin')->user()->type }}">
                  </div>

                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control"  name="name" value="{{ Auth::guard('admin')->user()->name }}">
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>

                <div class="form-group">
                  <label for="confirm_password">Mobile</label>
                  <input type="number" class="form-control" name="mobile" value="{{ Auth::guard('admin')->user()->mobile }}">
                  <p id="current_password_message"></p>
                  @error('mobile')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                    <label for="file">Profile Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @error('image')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                    <div class="col-md-12 my-2">
                        <a href="{{ asset('admin/profile_image/'.Auth::guard('admin')->user()->image) }}" target="_blank" title="view"><img id="preview-image-before-upload" src="{{ asset('admin/profile_image/'.Auth::guard('admin')->user()->image) }}"
                            alt="preview image" style="max-height: 150px;"></a>
                    </div>
                  </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

@endsection

@push('script')

{{-- image preview --}}
<script type="text/javascript">

    $(document).ready(function (e) {


       $('#image').change(function(){

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
