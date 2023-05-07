@extends('vendor.layout.layout')

@section('links')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
@endsection

@section('content')

<style>
    div.container { max-width: 1200px }
    .dataTables_wrapper .dataTables_paginate .paginate_button {padding: 0;}
</style>
    <div class="content-wrapper container">
        <div class="row">
            <div class="col-12">
                <table id="enquiry-table" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Schedule Date</th>
                            <th>Client Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>email</th>
                            <th>Budget</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($enquiries)
                          @foreach ($enquiries as $enquiry)
                          <tr>
                            <td>{{date('Y/m/d H:i:s',strtotime($enquiry->created_at))}}</td>
                            <td>{{ $request->client_name ?? $request->user->firtname }}</td>
                            <td>{{ $request->client_address }}</td>
                            <td>{{ $request->client_phone ?? $request->user->phone }}</td>
                            <td>{{ $request->client_email }}</td>
                            <td>{{ $request->client_budget }}</td>
                            <td>{{ $request->client_note }}</td>

                            @php  $color='text-warning'; @endphp

                            @if($request->client_status == 2)
                            @php  $color='text-success'; @endphp
                            @elseif ($request->client_status == 3)
                            @php  $color='text-danger'; @endphp
                            @elseif ($request->client_status == 4)
                            @php  $color='text-danger'; @endphp
                            @endif
                            <td class="{{ $color }}">{{ $request->client_status }}</td>
                            <td>
                                <button class="btn btn-primary" onClick="changeStatus(2)">Accept</button>
                                <button class="btn btn-danger" onClick="changeStatus(3)">Decline</button>
                            </td>
                        </tr>
                          @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
  <script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    $(document).ready(function () {
       var enquirytable = $('#enquiry-table').DataTable({
        responsive: true
    });

    function changeStatus(status){

        enquirytable.draw();
    }
});
  </script>
@endpush
