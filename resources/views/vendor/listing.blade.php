@extends('layouts.main')

@section('content')
    <style>
        .breadcrumb-bar {
            display: none !important;
        }
        .dashboard-content {
            padding: 120px 0 70px !important;
        }
        .msg-inquiry-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            margin-bottom: 18px;
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }
        .msg-inquiry-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
        }
        .msg-inquiry-card.is-unread {
            border-left: 4px solid #c10037;
            background: linear-gradient(to right, #fff9fa 0%, #ffffff 15%);
        }
        .msg-inquiry-header {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            border-bottom: 1px solid #f1f5f9;
        }
        .msg-user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #fee2e2;
            color: #c10037;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }
        .msg-inquiry-body {
            padding: 18px 20px;
        }
        .msg-inquiry-text {
            background: #f8fafc;
            border-radius: 10px;
            padding: 14px 16px;
            color: #334155;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 14px;
            border-left: 3px solid #cbd5e1;
        }
        .msg-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11.5px;
            font-weight: 700;
        }
        .msg-badge-unread {
            background: #ffe4e6;
            color: #9f1239;
        }
        .msg-badge-read {
            background: #f1f5f9;
            color: #475569;
        }
        .msg-badge-budget {
            background: #ecfdf5;
            color: #047857;
            font-weight: 700;
        }
    </style>

    <div class="dashboard-content">
        <div class="container">
            <div>
                @include('includes.tabs')
            </div>

            <div class="listing-content">
                <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: #0f172a;">Customer Inquiries & Messages</h4>
                        <p class="text-muted small mb-0">Direct customer leads and inquiries received through your public profile page.</p>
                    </div>
                </div>

                @if(isset($messages) && count($messages) > 0)
                    <div class="row">
                        @foreach ($messages as $key => $message)
                            <div class="col-12">
                                <div class="msg-inquiry-card {{ $message->is_read == 0 ? 'is-unread' : '' }}" id="main-message-{{ $message->id }}">
                                    <div class="msg-inquiry-header">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="msg-user-avatar">
                                                {{ strtoupper(substr($message->name ?? ($message->user->name ?? 'C'), 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark" id="message-title-{{ $message->id }}">
                                                    {{ $message->name ?? ($message->user->name ?? 'Customer') }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="feather-clock me-1"></i>{{ convertMdyToTimeAgo($message->created_at) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            @if($message->budget)
                                                <span class="msg-badge msg-badge-budget">
                                                    <i class="feather-dollar-sign"></i> Budget: ₹{{ $message->budget }}
                                                </span>
                                            @endif
                                            @if($message->is_read == 0)
                                                <span class="msg-badge msg-badge-unread" id="badge-status-{{ $message->id }}">
                                                    <i class="fas fa-circle" style="font-size: 8px;"></i> New Inquiry
                                                </span>
                                            @else
                                                <span class="msg-badge msg-badge-read">
                                                    <i class="fas fa-check"></i> Read
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="msg-inquiry-body">
                                        <div class="msg-inquiry-text">
                                            {{ $message->message }}
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pt-2">
                                            <div class="d-flex flex-wrap gap-3 small text-muted">
                                                @if(!empty($message->phone))
                                                    <div>
                                                        <i class="feather-phone me-1 text-primary"></i>
                                                        <strong class="text-dark">{{ $message->phone }}</strong>
                                                    </div>
                                                @endif
                                                @if(!empty($message->user->email))
                                                    <div>
                                                        <i class="feather-mail me-1 text-primary"></i>
                                                        <span class="text-dark">{{ $message->user->email }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                @if(!empty($message->phone))
                                                    <a href="tel:{{ $message->phone }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                                        <i class="feather-phone me-1"></i> Call
                                                    </a>
                                                @endif
                                                @if(!empty($message->user_id))
                                                    <a href="{{ route('chat.index', ['user_id' => $message->user_id]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="feather-message-square me-1"></i> Chat
                                                    </a>
                                                @endif
                                                @if($message->is_read == 0)
                                                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" onclick="readMessage(0, {{ $message->id }})" id="btn-read-{{ $message->id }}">
                                                        <i class="feather-check-circle me-1"></i> Mark as Read
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        {!! $messages->links() !!}
                    </div>
                @else
                    <div class="card p-5 text-center border-0 shadow-sm" style="border-radius: 16px;">
                        <i class="feather-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="fw-bold text-dark">No Inquiries Yet</h5>
                        <p class="text-muted small">When customers contact you from your public profile, inquiries will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    function readMessage(read, val) {
        if (read != 0) return false;
        $.ajax({
            url: "{{ url('vendor/read-status-update') }}/" + val,
            type: "get",
            success: function(data) {
                $("#main-message-" + val).removeClass('is-unread');
                $("#badge-status-" + val).replaceWith('<span class="msg-badge msg-badge-read"><i class="fas fa-check"></i> Read</span>');
                $("#btn-read-" + val).fadeOut();
            }
        });
    }
</script>
@endpush
