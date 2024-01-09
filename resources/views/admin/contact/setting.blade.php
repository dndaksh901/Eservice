@extends('admin.layout.layout')

@section('link')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error :</strong> {{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </li>
                        @endforeach

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
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Contact Page Setting</h4>
              <form action="{{ url('admin/contact-setting') }}" method="post" class="forms-sample">
                @csrf
                <div class="form-group">
                    <label for="address">Address</label>
                  <textarea id="address" name="address">{{ $contactPage->address ?? ''}}</textarea>
                </div>
                <div class="form-group">
                    <label for="availability">Availability</label>
                  <textarea id="availability" name="availability">{{ $contactPage->availability ?? ''}}</textarea>
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
<script src="https://cdn.tiny.cloud/1/5kuebtof2f6mvl2hzc1ag686wjwtqdup6x44ytagtbw6expp/tinymce/6/tinymce.min.js"
referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#address'
});
tinymce.init({
    selector: '#availability'
});
</script>
@endpush
