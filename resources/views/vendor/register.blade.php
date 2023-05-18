<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Vendor Register</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ url('admin/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ url('admin/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ url('admin/images/favicon.png') }}" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
              <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                  <div class="brand-logo">
                    <img src="{{ asset('admin/images/logo.svg') }}" alt="logo">
                  </div>
                  <h4>New here?</h4>
                  <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                  <form class="pt-3" action="{{ url('vendor/register') }}" method="post">
                    @csrf
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" value="{{ old('username') }}" autocomplete="off">
                      @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control form-control-lg" name="name" placeholder="Fullname" value="{{ old('name') }}" autocomplete="off">
                      @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    </div>

                    <div class="form-group">
                      <input type="email" class="form-control form-control-lg" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
                      @if ($errors->has('email'))
                      <span class="text-danger">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"  name="password" placeholder="Password" autocomplete="off">
                      @if ($errors->has('password'))
                      <span class="text-danger">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="confirm Password" name="password_confirmation" required>
                    </div>

                    <div class="mt-3">
                      <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Sign up</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                      Already have an account? <a href="{{ url('vendor/login') }}" class="text-primary">Login</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
      </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ url('admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ url('admin/js/off-canvas.js') }}"></script>
  <script src="{{ url('admin/js/hoverable-collapse.js') }}"></script>
  <script src="{{ url('admin/js/template.js') }}"></script>
  <script src="{{ url('admin/js/settings.js') }}"></script>
  <script src="{{ url('admin/js/todolist.js') }}"></script>
  <!-- endinject -->
</body>

</html>
