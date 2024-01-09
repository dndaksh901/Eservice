@extends('admin.layout.layout')

@section('link')

@endsection
@section('content')
<div class="container mt-2">
    <h1>Contact List</h1>

    <table id="users-table" class="table display expandable-table" style="width:100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->created_at }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ Str::limit($contact->subject,20) }}</td>
                    <td>{{ Str::limit($contact->message,50) }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.contact-show', $contact->id) }}" class="btn btn-primary">View</a> --}}
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewModal{{ $contact->id }}">View</a>
                        <button class="btn btn-danger" onclick="confirmDelete({{ $contact->id }})">Delete</button>
                    </td>

                </tr>
                <div class="modal fade" id="viewModal{{ $contact->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $contact->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel{{ $contact->id }}">View Message</h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-end">{{ $contact->created_at }}</p>
                                <!-- Display message details in the modal -->
                                <p><strong>Name:</strong> {{ $contact->name }}</p>
                                <p><strong>Email:</strong> {{ $contact->email }}</p>
                                <p><strong>Subject:</strong> {{ $contact->subject }}</p>
                                <p><strong>Message:</strong> {{ $contact->message }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $contacts->links() }} <!-- This will render the pagination links -->
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            responsive: true,
            paging:false,
        });
    });

    function confirmDelete(messageId) {
        if (confirm('Are you sure you want to delete this message?')) {
            // If the user confirms, redirect to the delete route
            window.location.href = '{{ url('admin/contact/delete') }}/' + messageId;
        }
    }
</script>

@endpush

