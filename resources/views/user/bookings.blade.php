@extends('layouts.main')

@section('meta_title', 'My Appointments & Bookings | ' . config('app.name', 'Eservice'))

@section('links')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
@endsection

@section('content')
<style>
    body {
        background-color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Page Header Section */
    .user-page-header {
        background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 125px 0 35px;
        position: relative;
    }
    .user-page-header::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #c10037 0%, #e11d48 35%, transparent 100%);
    }

    /* Breadcrumbs */
    .user-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        margin-bottom: 14px;
        padding: 0;
        list-style: none;
    }
    .user-breadcrumb a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .user-breadcrumb a:hover {
        color: #c10037;
    }
    .user-breadcrumb .separator {
        color: #cbd5e1;
        font-size: 11px;
    }
    .user-breadcrumb .active {
        color: #c10037;
        font-weight: 700;
    }

    /* Header Title Wrap */
    .page-title-wrap {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .page-title-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #fee2e2;
        color: #c10037;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(193, 0, 55, 0.12);
    }
    .page-main-heading {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 4px;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }
    .page-subheading {
        font-size: 14.5px;
        color: #64748b;
        margin-bottom: 0;
    }

    /* Content Wrapper */
    .bookings-container {
        padding: 35px 0 70px;
    }

    /* Stats Grid */
    .stat-card-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        transition: all 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(15, 23, 42, 0.06);
        border-color: #cbd5e1;
    }
    .stat-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .stat-icon-total { background: #f1f5f9; color: #334155; }
    .stat-icon-pending { background: #fef3c7; color: #d97706; }
    .stat-icon-confirmed { background: #e0f2fe; color: #0284c7; }
    .stat-icon-cancelled { background: #fee2e2; color: #dc2626; }
    .stat-number {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 2px;
    }
    .stat-title {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin: 0;
    }

    /* Filter & Search Bar */
    .filter-search-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 14px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .filter-pills-list {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .filter-pill-item {
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        color: #64748b;
        background: #f1f5f9;
        transition: all 0.2s ease;
        display: inline-block;
    }
    .filter-pill-item:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .filter-pill-item.active {
        background: #c10037;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(193, 0, 55, 0.25);
    }

    /* Search form */
    .search-input-group {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 270px;
    }
    .search-field {
        padding: 8px 14px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 13.5px;
        outline: none;
        width: 100%;
        transition: all 0.2s;
    }
    .search-field:focus {
        border-color: #c10037;
        box-shadow: 0 0 0 3px rgba(193, 0, 55, 0.1);
    }
    .search-btn {
        background: #c10037;
        color: #fff;
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13.5px;
        white-space: nowrap;
        cursor: pointer;
        transition: background 0.2s;
    }
    .search-btn:hover {
        background: #a1002e;
    }

    /* Booking Cards */
    .booking-list-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 22px 24px;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
        transition: all 0.2s ease;
    }
    .booking-list-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
    }
    .booking-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 14px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 16px;
    }
    .booking-ref-tag {
        font-family: monospace;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 4px 10px;
        border-radius: 8px;
        letter-spacing: 0.5px;
    }
    .booking-card-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr 0.8fr;
        gap: 20px;
        align-items: center;
    }
    @media (max-width: 991px) {
        .booking-card-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }
    .schedule-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
    }
    .status-confirmed { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .status-pending { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-completed { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
    .status-cancelled { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
</style>

<!-- Modern Page Header Section -->
<div class="user-page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <!-- Breadcrumbs -->
                <ul class="user-breadcrumb">
                    <li><a href="{{ url('/') }}"><i class="feather-home me-1"></i> Home</a></li>
                    <li class="separator"><i class="fas fa-chevron-right"></i></li>
                    <li><a href="javascript:void(0);">My Account</a></li>
                    <li class="separator"><i class="fas fa-chevron-right"></i></li>
                    <li class="active">My Bookings</li>
                </ul>

                <!-- Title & Subtitle -->
                <div class="page-title-wrap">
                    <div class="page-title-icon">
                        <i class="feather-calendar"></i>
                    </div>
                    <div>
                        <h1 class="page-main-heading">My Appointments & Service Bookings</h1>
                        <p class="page-subheading">
                            Track your selected time slots, check booking approvals, and view service details in real time.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Bookings Container -->
<div class="container bookings-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="feather-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
            <i class="feather-alert-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($requireLoginOrSearch)
        <!-- Guest Lookup Card -->
        <div class="row justify-content-center py-4">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
                    <div class="mb-3">
                        <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center" style="width: 72px; height: 72px; font-size: 30px; background: #fee2e2; color: #c10037;">
                            <i class="feather-search"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold text-dark">Track Your Booking Status</h4>
                    <p class="text-muted small mb-4">
                        Please log in to your account to view all your appointments, or enter your Booking Reference / Registered Phone below.
                    </p>

                    <form action="{{ route('user.bookings') }}" method="GET" class="text-start">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Booking Reference Code</label>
                            <input type="text" name="ref" class="form-control form-control-lg rounded-3" placeholder="e.g. BK-AB12CD" value="{{ request('ref') }}">
                        </div>
                        <div class="mb-3 text-center text-muted small fw-semibold">— OR —</div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">Mobile / Phone Number</label>
                            <input type="tel" name="phone" class="form-control form-control-lg rounded-3" placeholder="e.g. 9876543210" value="{{ request('phone') }}">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold" style="background:#c10037; border-color:#c10037;">
                                <i class="feather-search me-1"></i> Look Up Bookings
                            </button>
                            <a href="{{ url('login') }}" class="btn btn-outline-secondary rounded-pill">
                                <i class="feather-log-in me-1"></i> Log In to Your Account
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @else
        <!-- Metrics Stats Cards -->
        <div class="stat-card-row">
            <div class="stat-box">
                <div class="stat-icon-wrapper stat-icon-total">
                    <i class="feather-layers"></i>
                </div>
                <div>
                    <div class="stat-number">{{ $totalCount }}</div>
                    <p class="stat-title">Total Bookings</p>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon-wrapper stat-icon-pending">
                    <i class="feather-clock"></i>
                </div>
                <div>
                    <div class="stat-number text-warning">{{ $pendingCount }}</div>
                    <p class="stat-title">Pending</p>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon-wrapper stat-icon-confirmed">
                    <i class="feather-check-circle"></i>
                </div>
                <div>
                    <div class="stat-number text-success">{{ $confirmedCount }}</div>
                    <p class="stat-title">Confirmed</p>
                </div>
            </div>
            <div class="stat-box">
                <div class="stat-icon-wrapper stat-icon-cancelled">
                    <i class="feather-x-circle"></i>
                </div>
                <div>
                    <div class="stat-number text-danger">{{ $cancelledCount }}</div>
                    <p class="stat-title">Cancelled</p>
                </div>
            </div>
        </div>

        <!-- Filter Pills & Search Form -->
        <div class="filter-search-box">
            <div class="filter-pills-list">
                <a class="filter-pill-item {{ $status === 'all' ? 'active' : '' }}" 
                    href="{{ route('user.bookings', array_merge(request()->query(), ['status' => 'all'])) }}">
                    All ({{ $totalCount }})
                </a>
                <a class="filter-pill-item {{ $status === 'pending' ? 'active' : '' }}" 
                    href="{{ route('user.bookings', array_merge(request()->query(), ['status' => 'pending'])) }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a class="filter-pill-item {{ $status === 'confirmed' ? 'active' : '' }}" 
                    href="{{ route('user.bookings', array_merge(request()->query(), ['status' => 'confirmed'])) }}">
                    Confirmed ({{ $confirmedCount }})
                </a>
                <a class="filter-pill-item {{ $status === 'completed' ? 'active' : '' }}" 
                    href="{{ route('user.bookings', array_merge(request()->query(), ['status' => 'completed'])) }}">
                    Completed ({{ $completedCount }})
                </a>
                <a class="filter-pill-item {{ $status === 'cancelled' ? 'active' : '' }}" 
                    href="{{ route('user.bookings', array_merge(request()->query(), ['status' => 'cancelled'])) }}">
                    Cancelled ({{ $cancelledCount }})
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('user.bookings') }}" method="GET" class="search-input-group">
                <input type="hidden" name="status" value="{{ $status }}">
                @if(!empty($guestRef)) <input type="hidden" name="ref" value="{{ $guestRef }}"> @endif
                @if(!empty($guestPhone)) <input type="hidden" name="phone" value="{{ $guestPhone }}"> @endif
                <input type="text" name="search" class="search-field" placeholder="Search reference, vendor..." value="{{ $search }}">
                @if(!empty($search))
                    <a href="{{ route('user.bookings', ['status' => $status]) }}" class="btn btn-sm btn-outline-secondary rounded-3">Clear</a>
                @endif
                <button type="submit" class="search-btn">
                    <i class="feather-search me-1"></i> Search
                </button>
            </form>
        </div>

        <!-- Bookings List -->
        @if($bookings->count() > 0)
            <div class="d-flex flex-column gap-3 mb-4">
                @foreach($bookings as $booking)
                    <div class="booking-list-item">
                        <!-- Top Bar with Reference & Date -->
                        <div class="booking-card-top">
                            <div class="d-flex align-items-center gap-2">
                                <span class="booking-ref-tag">{{ $booking->booking_reference }}</span>
                                <small class="text-muted">Requested on {{ $booking->created_at->format('d M Y, h:i A') }}</small>
                            </div>
                            <div>
                                @if($booking->status === 'confirmed')
                                    <span class="status-pill status-confirmed">
                                        <i class="feather-check-circle"></i> Confirmed by Provider
                                    </span>
                                @elseif($booking->status === 'completed')
                                    <span class="status-pill status-completed">
                                        <i class="feather-check-square"></i> Service Completed
                                    </span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="status-pill status-cancelled">
                                        <i class="feather-x-circle"></i> Cancelled
                                    </span>
                                @else
                                    <span class="status-pill status-pending">
                                        <i class="feather-clock"></i> Awaiting Provider Confirmation
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 3-Column Content Grid -->
                        <div class="booking-card-grid">
                            <!-- Left: Vendor Info -->
                            <div>
                                <div class="d-flex align-items-start gap-3">
                                    <div style="width: 54px; height: 54px; border-radius: 12px; overflow: hidden; background: #fee2e2; display: flex; align-items: center; justify-content: center; font-size: 22px; color: #c10037; font-weight: bold; flex-shrink: 0;">
                                        @if(!empty($booking->vendor->avatar))
                                            <img src="{{ asset('vendor/vendor_image/' . $booking->vendor->avatar) }}" alt="{{ $booking->vendor->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            {{ strtoupper(substr($booking->vendor->name ?? 'V', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-1 text-dark" style="font-size: 16px;">
                                            <a href="{{ route('vendor.detail', $booking->vendor_id) }}" class="text-dark text-decoration-none">
                                                {{ $booking->vendor->name ?? $booking->vendor->username ?? 'Service Provider' }}
                                            </a>
                                        </h5>
                                        <div class="small text-muted mb-1">
                                            <span class="text-primary fw-semibold">
                                                <i class="feather-tag me-1"></i>{{ $booking->service_title ?? ($booking->vendor->profile->occupation->occupation_name ?? 'General Service') }}
                                            </span>
                                            @if(!empty($booking->vendor->profile->city->name))
                                                <span>&bull;</span>
                                                <span><i class="feather-map-pin me-1"></i>{{ $booking->vendor->profile->city->name }}</span>
                                            @endif
                                        </div>
                                        @if($booking->price)
                                            <div class="small fw-bold text-dark">
                                                Estimated Rate: <span class="text-danger">₹{{ number_format($booking->price, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Middle: Appointment Date & Time Slot -->
                            <div>
                                <div class="schedule-box">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="feather-calendar text-danger"></i>
                                        <span class="fw-bold text-dark" style="font-size: 14px;">
                                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('D, d M Y') }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 text-muted small mb-2">
                                        <i class="feather-clock text-primary"></i>
                                        <span class="fw-bold text-dark">{{ $booking->booking_time_slot }}</span>
                                    </div>
                                    <div class="small text-muted text-truncate" title="{{ $booking->booking_address }}">
                                        <i class="feather-map-pin text-secondary me-1"></i> {{ $booking->booking_address }}
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Actions -->
                            <div class="text-lg-end">
                                <div class="d-flex align-items-center justify-content-lg-end gap-2 flex-wrap">
                                    <a href="{{ url('/chat') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                        <i class="feather-message-square me-1"></i> Chat
                                    </a>

                                    <a href="{{ route('vendor.detail', $booking->vendor_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        View Profile
                                    </a>

                                    @if($booking->status === 'pending')
                                        <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this appointment request?');">
                                            @csrf
                                            @if(!Auth::check())
                                                <input type="hidden" name="verify_phone" value="{{ $booking->customer_phone }}">
                                            @endif
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                Cancel Request
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!empty($booking->notes))
                            <div class="mt-3 pt-3 border-top small text-muted">
                                <i class="feather-info text-info me-1"></i> <strong>Note:</strong> {{ $booking->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-4">
                <div class="mx-auto rounded-circle d-flex align-items-center justify-content-center bg-light text-muted mb-3" style="width: 80px; height: 80px; font-size: 36px;">
                    <i class="feather-calendar"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">No Bookings Found</h4>
                <p class="text-muted mb-4">
                    @if(!empty($search) || $status !== 'all')
                        No appointments match your current search criteria. Try resetting filters.
                    @else
                        You haven't scheduled any service appointments yet. Discover verified local professionals near you.
                    @endif
                </p>
                <div class="d-flex justify-content-center gap-2">
                    @if(!empty($search) || $status !== 'all')
                        <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            Reset Filters
                        </a>
                    @endif
                    <a href="{{ url('/search') }}" class="btn btn-primary rounded-pill px-4" style="background:#c10037; border-color:#c10037;">
                        Explore & Book Services
                    </a>
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
