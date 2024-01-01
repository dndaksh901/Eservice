@extends('admin.layout.layout')

@section('content')
<div class="container mt-2">
    <h1>Countries</h1>

    <table id="users-table" class="display expandable-table" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
                <tr>
                    <td>{{ Str::ucfirst($country->name) }}</td>
                    <td>{{ $country->status =="active"? 'Enabled' : 'Disabled' }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.countries.enableDisable', $country->id) }}">
                            {!! $country->status =="active" ? 'Disable' : 'Enable' !!!}
                        </a> --}}
                        <form action="{{ route('admin.countries.enableDisable', $country->id) }}" method="post">
                            @csrf
                            @method('PUT') {{-- Assuming you are using the PUT method for updating --}}
                            <button type="submit" class="btn btn-{{ $country->status == 'active' ? 'danger' : 'success' }}">
                                {{ $country->status == 'active' ? 'Disable' : 'Enable' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $countries->links() }} <!-- This will render the pagination links -->
@endsection
@push('script')

<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            responsive: true,
            paging:false,
        });
    });
</script>

@endpush

