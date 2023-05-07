@extends('vendor.layout.layout')

@section('content')
<style>
        img.profile-side-image{
        position: fixed;
        max-width: 41.5%;
        width: 100%;
    }
</style>
    <div class="content-wrapper">
        <div class="row">
            @if(session()->has('error'))
                    <span class="alert alert-danger col-12">
                        <strong>{{ session()->get('error') }}</strong>
                    </span>
                @endif
                @if(session()->has('success'))
                    <span class="alert alert-success col-12">
                        <strong>{{ session()->get('success') }}</strong>
                    </span>
                @endif
          </div>
      <div class="row">
        <div class="col-lg-6 col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Vendor Password</h4>
              <form action="{{ url('vendor/update-current-password') }}" method="post" class="forms-sample">
                @csrf
                <div class="form-group">
                  <label for="exampleInputUsername1">Username</label>
                  <input type="text" class="form-control" readonly value="{{ Auth::guard('vendor')->user()->username}}">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" class="form-control" readonly value="{{ Auth::guard('vendor')->user()->email }}">
                </div>
                <div class="form-group">
                  <label for="current_password">Password</label>
                  <input type="password" class="form-control" id="current_password" placeholder="Current Password" name="current_password" value="" onkeyup="checkCurrentPassword(this.value)" autocomplete="off" autofocus="off">
                  <p id="current_password_message"></p>
                  @error('current_password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="new_password">New Password</label>
                  <input type="password" class="form-control @error('password') is-invalid @enderror" id="new_password" placeholder="Current Password" name="password">
                  <p id="current_password_message"></p>
                  @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password"  class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" autocomplete="password_confirmation">
                  <p id="current_password_message"></p>
                  @error('password_confirmation')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button class="btn btn-light">Cancel</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div><img src="{{ asset('vendor/password-page.png')}}" alt="password-image" class="img-fluid profile-side-image"></div>
        </div>
      </div>
    </div>

@endsection

@push('script')
  <script>
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //Check current password
        function checkCurrentPassword(password){

             $.ajax({
                url:"{{ url('vendor/check-current-password') }}",
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
