@extends('admin.layout.layout')

@section('content')
    <div class="container mt-2">
        <h2>Vendor List</h2>
        {{-- <table id="users-table" class="table table-bordered table-responsive"> --}}
            <table id="users-table" class="display expandable-table" style="width:100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Profession</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendors as $user)
                    <tr>
                        <td><a href="{{ url('admin/auto-login/' . $user->email) }}" target="_blank">Login</a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->profile->occupation->occupation_name ??'' }}</td>
                        <td>{{ $user->profile->experience_year ?? '0' }} Yrs {{ $user->profile->experience_month ?? '0'}} M</td>
                        <td>
                            <p>{{ $user->name }} - Status: {{ $user->status == 0 ? 'Inactive' : 'Active'  }}</p>
                            <form action="{{ route('admin.changeStatus', ['userId' => $user->id, 'status' => $user->status == 0 ? 1 : 0]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-info">Change Status</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.vendorstatus', ['id' => $user->id]) }}" class="btn btn-primary">Edit</a>
                            {{-- <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('script')

<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            responsive: true
        });
    });
</script>

@endpush
