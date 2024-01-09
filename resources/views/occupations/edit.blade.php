@extends('admin.layout.layout')

@section('content')
    <div class="container">
        <h2>Edit Occupation</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('occupations.update', $occupation->id) }}" method="POST">
            @csrf
            {{-- @method('PUT') <!-- Use PUT method for updates --> --}}

            <div class="form-group">
                <label for="occupation">Occupation Name</label>
                <input type="text" class="form-control @error('occupation_name') is-invalid @enderror" id="occupation" name="occupation_name" value="{{ old('occupation_name', $occupation->occupation_name) }}" required>
                @error('occupation_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="checkbox" name="status" id="status" {{ $occupation->status==1 ? 'checked' : '' }}>
            </div>

            <!-- Add other form fields as needed -->

            <button type="submit" class="btn btn-primary">Update Occupation</button>
            <a href="{{ route('occupations.index') }}" class="btn btn-danger">Cancel</a>
        </form>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif
    </div>
@endsection

@push('script')
    <!-- Include Bootstrap Switch JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-switch@3/dist/js/bootstrap-switch.min.js"></script>
    <script>
        $(document).ready(function(){
            $("[data-toggle='switch']").bootstrapSwitch();
        });
    </script>
@endpush
