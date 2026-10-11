@extends('layouts.main')

@section('meta_title', 'Appointment Bookings & Schedule | ' . config('app.name', 'Eservice'))

@section('links')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    .dashboard-content {
        padding: 120px 0 70px;
    }

    /* Stats Cards */
    .booking-stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .booking-stat-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .booking-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.08);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-icon-all { background: #f1f5f9; color: #334155; }
    .stat-icon-pending { background: #fef3c7; color: #d97706; }
    .stat-icon-confirmed { background: #e0f2fe; color: #0284c7; }
    .stat-icon-completed { background: #d1fae5; color: #059669; }

    .stat-value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 2px;
    }
    .stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
        margin: 0;
    }

    /* Filter Bar */
    .booking-filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .filter-pills {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .filter-pill {
        padding: 7px 15px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        color: #64748b;
        background: #f1f5f9;
        transition: all 0.2s ease;
    }
    .filter-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .filter-pill.active {
        background: #c10037;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(193, 0, 55, 0.25);
    }
    .booking-search-form {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 260px;
    }
    .booking-search-input {
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        outline: none;
        width: 100%;
    }
    .booking-search-input:focus {
        border-color: #c10037;
        box-shadow: 0 0 0 3px rgba(193, 0, 55, 0.1);
    }

    /* Booking Cards List */
    .booking-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        padding: 22px 24px;
        margin-bottom: 18px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .booking-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.07);
    }
    .booking-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 14px;
    }
    .booking-ref-badge {
        font-family: monospace;
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 8px;
    }
    .booking-body-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .booking-detail-item {
        font-size: 13.5px;
    }
    .detail-label {
        font-size: 11.5px;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 700;
        letter-spacing: 0.04em;
        margin-bottom: 3px;
    }
    .detail-value {
        color: #1e293b;
        font-weight: 600;
        line-height: 1.4;
    }
    .detail-value a {
        color: #c10037;
        text-decoration: none;
    }
    .detail-value a:hover {
        text-decoration: underline;
    }
    .booking-address-box {
        background: #f8fafc;
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        color: #475569;
        margin-bottom: 16px;
        border: 1px dashed #e2e8f0;
    }
    .booking-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-action {
        padding: 7px 15px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .btn-confirm {
        background: #10b981;
        color: #ffffff !important;
    }
    .btn-confirm:hover {
        background: #059669;
        box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
    }
    .btn-complete {
        background: #0284c7;
        color: #ffffff !important;
    }
    .btn-complete:hover {
        background: #0369a1;
        box-shadow: 0 3px 10px rgba(2, 132, 199, 0.3);
    }
    .btn-cancel {
        background: #f1f5f9;
        color: #ef4444 !important;
        border: 1px solid #fee2e2;
    }
    .btn-cancel:hover {
        background: #fee2e2;
        color: #dc2626 !important;
    }
    .btn-chat {
        background: #25d366;
        color: #ffffff !important;
    }
    .btn-chat:hover {
        background: #1eb855;
    }
    .btn-call {
        background: #0f172a;
        color: #ffffff !important;
    }
    .btn-call:hover {
        background: #000000;
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    <div class="container">

        <!-- Modern Vendor Tabs -->
        @include('includes.tabs')

        <!-- Flash Notifications -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 py-3 px-4 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 py-3 px-4 mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Quick Stats Cards -->
        <div class="booking-stat-grid">
            <div class="booking-stat-card">
                <div class="stat-icon stat-icon-all"><i class="feather-calendar"></i></div>
                <div>
                    <div class="stat-value">{{ $totalCount }}</div>
                    <p class="stat-label">Total Appointments</p>
                </div>
            </div>
            <div class="booking-stat-card">
                <div class="stat-icon stat-icon-pending"><i class="feather-clock"></i></div>
                <div>
                    <div class="stat-value text-warning">{{ $pendingCount }}</div>
                    <p class="stat-label">Pending Confirmation</p>
                </div>
            </div>
            <div class="booking-stat-card">
                <div class="stat-icon stat-icon-confirmed"><i class="feather-check-circle"></i></div>
                <div>
                    <div class="stat-value text-primary">{{ $confirmedCount }}</div>
                    <p class="stat-label">Confirmed Upcoming</p>
                </div>
            </div>
            <div class="booking-stat-card">
                <div class="stat-icon stat-icon-completed"><i class="feather-award"></i></div>
                <div>
                    <div class="stat-value text-success">{{ $completedCount }}</div>
                    <p class="stat-label">Completed Jobs</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="booking-filter-bar">
            <div class="filter-pills">
                <a href="{{ route('vendor.bookings', ['status' => 'all', 'search' => $search]) }}" class="filter-pill {{ $status == 'all' ? 'active' : '' }}">
                    All ({{ $totalCount }})
                </a>
                <a href="{{ route('vendor.bookings', ['status' => 'pending', 'search' => $search]) }}" class="filter-pill {{ $status == 'pending' ? 'active' : '' }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('vendor.bookings', ['status' => 'confirmed', 'search' => $search]) }}" class="filter-pill {{ $status == 'confirmed' ? 'active' : '' }}">
                    Confirmed ({{ $confirmedCount }})
                </a>
                <a href="{{ route('vendor.bookings', ['status' => 'completed', 'search' => $search]) }}" class="filter-pill {{ $status == 'completed' ? 'active' : '' }}">
                    Completed ({{ $completedCount }})
                </a>
                <a href="{{ route('vendor.bookings', ['status' => 'cancelled', 'search' => $search]) }}" class="filter-pill {{ $status == 'cancelled' ? 'active' : '' }}">
                    Cancelled ({{ $cancelledCount }})
                </a>
            </div>

            <form action="{{ route('vendor.bookings') }}" method="GET" class="booking-search-form">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Search customer, ref #, phone..." class="booking-search-input">
                <button type="submit" class="btn btn-sm btn-dark px-3 py-2 rounded-3 fw-bold">
                    <i class="feather-search"></i>
                </button>
                @if(!empty($search))
                    <a href="{{ route('vendor.bookings', ['status' => $status]) }}" class="btn btn-sm btn-light py-2 rounded-3" title="Clear Search">
                        <i class="feather-x"></i>
                    </a>
                @endif
            </form>
        </div>

        <!-- Bookings Listing -->
        @if ($bookings->count() > 0)
            @foreach ($bookings as $booking)
                <div class="booking-card" id="booking-item-{{ $booking->id }}">
                    <div class="booking-header">
                        <div class="d-flex align-items-center gap-3">
                            <span class="booking-ref-badge">{{ $booking->booking_reference }}</span>
                            <span class="text-muted small">
                                <i class="feather-clock me-1"></i> Booked on {{ $booking->created_at->format('M d, Y h:i A') }}
                            </span>
                        </div>
                        <div id="booking-badge-{{ $booking->id }}">
                            {!! $booking->status_badge !!}
                        </div>
                    </div>

                    <div class="booking-body-grid">
                        <div class="booking-detail-item">
                            <div class="detail-label">Client Name</div>
                            <div class="detail-value text-dark fw-bold">{{ $booking->customer_name }}</div>
                        </div>

                        <div class="booking-detail-item">
                            <div class="detail-label">Contact Phone</div>
                            <div class="detail-value">
                                <a href="tel:{{ $booking->customer_phone }}">
                                    <i class="feather-phone me-1"></i> {{ $booking->customer_phone }}
                                </a>
                            </div>
                        </div>

                        <div class="booking-detail-item">
                            <div class="detail-label">Appointment Schedule</div>
                            <div class="detail-value text-primary">
                                <i class="feather-calendar me-1"></i> {{ $booking->booking_date->format('D, M d, Y') }}
                                <div class="small text-muted fw-bold mt-1">
                                    <i class="feather-clock me-1"></i> {{ $booking->booking_time_slot }}
                                </div>
                            </div>
                        </div>

                        <div class="booking-detail-item">
                            <div class="detail-label">Service & Charges</div>
                            <div class="detail-value">
                                <div>{{ $booking->service_title ?? 'General Service' }}</div>
                                @if($booking->price)
                                    <span class="badge bg-success-subtle text-success mt-1">₹ {{ $booking->price }} / visit</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(!empty($booking->booking_address))
                        <div class="booking-address-box">
                            <strong><i class="feather-map-pin me-1 text-danger"></i> Service Location:</strong>
                            {{ $booking->booking_address }}
                        </div>
                    @endif

                    @if(!empty($booking->notes))
                        <div class="small text-muted mb-3 fst-italic">
                            <i class="feather-info me-1 text-info"></i> <strong>Customer Notes:</strong> "{{ $booking->notes }}"
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="booking-actions">
                        <a href="tel:{{ $booking->customer_phone }}" class="btn-action btn-call">
                            <i class="feather-phone"></i> Call
                        </a>

                        @if ($booking->user_id)
                            <a href="{{ route('chat.index', ['user_id' => $booking->user_id]) }}" class="btn-action btn-chat">
                                <i class="fas fa-comment-dots"></i> Live Chat
                            </a>
                        @endif

                        @if ($booking->status === 'pending')
                            <button type="button" class="btn-action btn-confirm" onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                                <i class="feather-check"></i> Confirm Appointment
                            </button>
                            <button type="button" class="btn-action btn-cancel" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                                <i class="feather-x"></i> Decline
                            </button>
                        @elseif ($booking->status === 'confirmed')
                            <button type="button" class="btn-action btn-complete" onclick="updateBookingStatus({{ $booking->id }}, 'completed')">
                                <i class="feather-check-circle"></i> Mark Completed
                            </button>
                            <button type="button" class="btn-action btn-cancel" onclick="updateBookingStatus({{ $booking->id }}, 'cancelled')">
                                <i class="feather-x"></i> Cancel Appointment
                            </button>
                        @elseif ($booking->status === 'cancelled')
                            <button type="button" class="btn-action btn-confirm" onclick="updateBookingStatus({{ $booking->id }}, 'confirmed')">
                                <i class="feather-rotate-ccw"></i> Reopen
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $bookings->appends(['status' => $status, 'search' => $search])->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 border">
                <i class="feather-calendar fa-3x text-muted mb-3 d-block"></i>
                <h4 class="fw-bold text-dark">No Appointments Found</h4>
                <p class="text-muted small mb-3">
                    {{ !empty($search) ? "No bookings match your search '{$search}'" : "You do not have any {$status} appointments at the moment." }}
                </p>
                <a href="{{ route('vendor.bookings') }}" class="btn btn-outline-dark rounded-pill px-4 btn-sm fw-bold">
                    View All Bookings
                </a>
            </div>
        @endif

    </div>
</div>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    function updateBookingStatus(bookingId, newStatus) {
        swal({
            title: "Confirm Status Change?",
            text: "Are you sure you want to change this appointment to " + newStatus + "?",
            icon: "warning",
            buttons: ["Cancel", "Yes, Update"],
            dangerMode: newStatus === 'cancelled'
        }).then(function(willUpdate) {
            if (willUpdate) {
                $.ajax({
                    url: "{{ url('vendor/bookings') }}/" + bookingId + "/status",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: newStatus
                    },
                    success: function(response) {
                        if (response.success) {
                            swal({
                                title: "Updated!",
                                text: response.message,
                                icon: "success",
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        swal("Error", "Could not update status. Please try again.", "error");
                    }
                });
            }
        });
    }
</script>
@endpush
