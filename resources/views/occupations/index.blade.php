@extends('admin.layout.layout')

@section('content')
    <div class="container">
        <h2>Occupations</h2>

        <a href="{{ route('occupations.create') }}" class="btn btn-primary mb-3">Create Occupation</a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table" id="occupationsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Occupation</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($occupations as $occupation)
                    <tr>
                        <td>{{ $occupation->id }}</td>
                        <td>{{ $occupation->occupation_name }}</td>
                        <td>{{ $occupation->slug }}</td>
                        <td>{!! $occupation->status==0 ? '<span class="text-danger">Inactive<span>':'<span class="text-success">Active</span>' !!}</td>
                        <td>
                            <a href="{{ route('occupations.edit', $occupation->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('occupations.destroy', $occupation->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this occupation?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No occupations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Display pagination links -->
        {{ $occupations->links() }}
    </div>


@endsection
@push('script')
<script>
    $(document).ready(function () {
        // Initialize DataTables
        $('#occupationsTable').DataTable({
            paging: false

    });
    });
</script>
@endpush
