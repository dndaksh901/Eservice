@extends('layouts.main')

@section('content')
    <style>
        .accordion .card-header:after {
            font-family: 'FontAwesome';
            content: "\f068";
            float: right;
        }

        .accordion .card-header.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\f067";
        }

        .message-time {
            float: right;
            color: #c2c2c2;
            margin-left: 2rem;
        }

        .user-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .bg-color {
            background: #c10037;
            color: #fff;
            border-radius: 5px;
        }
    </style>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Message</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Message</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="dashboard-content">
        <div class="container">
            <div class="">
                @include('includes.tabs')
            </div>
            <div class="listing-content">
                <div class="container">
                    <div id="accordion" class="accordion">
                        <div class="card mb-0" id="message-card">
                            @if (isset($messages))
                                @foreach ($messages as $key => $message)
                                    <div class="card-header collapsed {{ $message->is_read == 0 ? 'bg-color' : '' }}"
                                        data-toggle="collapse" href="#collapse{{ $key }}"
                                        id="main-message-{{ $message->id }}" onclick="{{ $message->is_read == 0 ? "readMessage($message->is_read,$message->id)" : '' }}">
                                        <a class="card-title {{ $message->is_read == 0 ? 'text-white' : '' }}"
                                            id="message-title-{{ $message->id }}">
                                            <img src="{{ asset('vendor/profile_image/avatar.jpg') }}"
                                                alt="profile-image" class="user-image">
                                            {{ $message->name ?? $message->user->name }}
                                        </a>
                                        <span class="message-time">({{ convertMdyToTimeAgo($message->created_at) }})</span>
                                    </div>

                                    <div id="collapse{{ $key }}" class="card-body collapse"
                                        data-parent="#accordion">
                                        <div class="card">
                                            <div class="card-body">
                                                <p><strong>Name: </strong> {{ $message->name ?? $message->user->name }}</p>
                                                <p><strong>Contact Number: </strong> {{ $message->phone ?? '' }}</p>
                                                <p><strong>Email: </strong>{{ $message->user->email ?? '' }}</p>
                                                <p><strong>Budget: </strong>Rs {{ $message->budget ?? '' }}</p>
                                                <p><strong>Message: </strong>{{ $message->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-center">
                                    {!! $messages->links() !!}
                                </div>

                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')

<script>

    // var page = 1;
    // loadMore(page);

    // function loadMore(page){
    //     $.ajax({
    //         url:"{{ url('vendor/message')}}/"+page,
    //         type:"get",
    //         datatype:"html",
    //         success:function(data){
    //             alert('test');
    //             if(data.length!=0){
    //             $('#message-card').append(data);
    //             }
    //         }
    //     })
    // }
    function readMessage(read,val){
    if(read != 0){
        return false;
    }else{
        $.ajax({
            url:"{{ url('vendor/read-status-update')}}/"+val,
            type:"get",
            success:function(data){
                $("#main-message-"+val).removeClass('bg-color');
                $("#message-title-"+val).removeClass('text-white');
            }
        })

    }
    }
</script>
@endpush
