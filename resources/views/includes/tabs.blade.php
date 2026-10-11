@php
    $vendorUser = Auth::guard('vendor')->user();
    $vendorId = $vendorUser->id ?? 0;
    $unreadMsg = \App\Models\Notification::where('vendor_id', $vendorId)->where('is_read', 0)->count();
    $pendingBookings = \App\Models\Booking::where('vendor_id', $vendorId)->where('status', 'pending')->count();
    $vendorProfile = $vendorUser ? \App\Models\Profile::where('vendor_id', $vendorId)->first() : null;
@endphp

<style>
    /* =========================================
       MODERN VENDOR DASHBOARD HEADER & TABS
       ========================================= */
    .vendor-portal-header {
        background: linear-gradient(135deg, #091224 0%, #111d38 50%, #1e293b 100%);
        border-radius: 20px;
        padding: 26px 30px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.15);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }
    .vp-header-user {
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .vp-header-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.25);
        box-shadow: 0 4px 14px rgba(0,0,0,0.2);
        background: #1e293b;
    }
    .vp-header-details h3 {
        color: #ffffff;
        font-size: 22px;
        font-weight: 800;
        margin: 0 0 4px;
        letter-spacing: -0.02em;
    }
    .vp-header-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
        color: #cbd5e1;
    }
    .vp-header-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(16, 185, 129, 0.18);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #34d399;
        padding: 3px 10px;
        border-radius: 999px;
        font-weight: 700;
        font-size: 11.5px;
    }
    .vp-header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .vp-view-profile-btn {
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 700;
        padding: 9px 18px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .vp-view-profile-btn:hover {
        background: #ffffff;
        color: #0f172a !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(255, 255, 255, 0.2);
    }

    /* Modern Navigation Tabs */
    .vendor-nav-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 8px;
        margin-bottom: 28px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        overflow-x: auto;
    }
    .vendor-nav-tabs {
        display: flex;
        align-items: center;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
        min-width: max-content;
    }
    .vendor-nav-item {
        margin: 0;
    }
    .vendor-nav-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        position: relative;
    }
    .vendor-nav-link i {
        font-size: 15px;
        transition: transform 0.2s;
    }
    .vendor-nav-link:hover {
        color: #c10037;
        background: rgba(193, 0, 55, 0.06);
    }
    .vendor-nav-link:hover i {
        transform: scale(1.1);
    }
    .vendor-nav-link.active {
        background: linear-gradient(135deg, #c10037 0%, #e11d48 100%);
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(193, 0, 55, 0.3);
    }
    .vendor-nav-badge {
        padding: 2px 7px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        line-height: 1.2;
    }
    .vendor-nav-badge-amber {
        background: #fef3c7;
        color: #92400e;
    }
    .vendor-nav-link.active .vendor-nav-badge-amber {
        background: #ffffff;
        color: #c10037;
    }
    .vendor-nav-badge-green {
        background: #d1fae5;
        color: #065f46;
    }
    .vendor-nav-link.active .vendor-nav-badge-green {
        background: #ffffff;
        color: #059669;
    }
    .vendor-nav-logout {
        color: #ef4444 !important;
    }
    .vendor-nav-logout:hover {
        background: #fef2f2 !important;
        color: #b91c1c !important;
    }

    @media (max-width: 768px) {
        .vendor-portal-header {
            padding: 20px 18px;
        }
        .vp-header-user {
            flex-direction: column;
            text-align: center;
            width: 100%;
        }
        .vp-header-details h3 {
            font-size: 20px;
        }
        .vp-header-meta {
            justify-content: center;
        }
        .vp-header-actions {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- Vendor Portal Top Banner -->
<div class="vendor-portal-header">
    <div class="vp-header-user">
        <img src="{{ asset('vendor/vendor_image/' . ($vendorUser->avatar ?? 'avatar.jpg')) }}"
             onerror="this.onerror=null;this.src='{{ asset('vendor/vendor_image/avatar.jpg') }}';"
             class="vp-header-avatar"
             alt="{{ $vendorUser->name ?? 'Vendor' }}">
        <div class="vp-header-details">
            <h3>{{ $vendorUser->name ?? $vendorUser->username ?? 'Provider Portal' }}</h3>
            <div class="vp-header-meta">
                <span class="vp-header-badge"><i class="fas fa-check-circle"></i> Verified Provider</span>
                <span><i class="feather-phone me-1"></i> {{ $vendorUser->mobile ?? 'No phone' }}</span>
                <span><i class="feather-mail me-1"></i> {{ $vendorUser->email ?? '' }}</span>
            </div>
        </div>
    </div>
    <div class="vp-header-actions">
        @if ($vendorProfile)
            <a href="{{ vendorProfileUrl($vendorProfile) }}" target="_blank" class="vp-view-profile-btn">
                <i class="feather-external-link"></i> View Public Profile
            </a>
        @endif
    </div>
</div>

<!-- Modern Horizontal Navigation Tabs -->
<div class="vendor-nav-container">
    <ul class="vendor-nav-tabs">
        <li class="vendor-nav-item">
            <a href="{{ url('vendor/profile') }}" class="vendor-nav-link {{ request()->is('vendor/profile') ? 'active' : '' }}">
                <i class="feather-user"></i> <span>Profile</span>
            </a>
        </li>
        <li class="vendor-nav-item">
            <a href="{{ url('vendor/profession') }}" class="vendor-nav-link {{ request()->is('vendor/profession') ? 'active' : '' }}">
                <i class="feather-briefcase"></i> <span>Profession</span>
            </a>
        </li>
        <li class="vendor-nav-item">
            <a href="{{ url('vendor/business-hours') }}" class="vendor-nav-link {{ request()->is('vendor/business-hours') ? 'active' : '' }}">
                <i class="feather-clock"></i> <span>Business Hours</span>
            </a>
        </li>
        <li class="vendor-nav-item">
            <a href="{{ route('vendor.bookings') }}" class="vendor-nav-link {{ request()->is('vendor/bookings*') ? 'active' : '' }}">
                <i class="feather-calendar"></i>
                <span>Bookings</span>
                @if ($pendingBookings > 0)
                    <span class="vendor-nav-badge vendor-nav-badge-amber">{{ $pendingBookings }}</span>
                @endif
            </a>
        </li>
        <li class="vendor-nav-item">
            <a href="{{ route('chat.index') }}" class="vendor-nav-link {{ request()->is('chat*') ? 'active' : '' }}">
                <i class="feather-message-circle"></i>
                <span>Live Chat</span>
            </a>
        </li>
        <li class="vendor-nav-item">
            <a href="{{ url('vendor/message') }}" class="vendor-nav-link {{ request()->is('vendor/message*') ? 'active' : '' }}">
                <i class="feather-mail"></i>
                <span>Inquiries</span>
                @if ($unreadMsg > 0)
                    <span class="vendor-nav-badge vendor-nav-badge-green">{{ $unreadMsg }}</span>
                @endif
            </a>
        </li>
        <li class="vendor-nav-item ms-auto">
            <a href="{{ url('vendor/logout') }}" class="vendor-nav-link vendor-nav-logout"
               onclick="event.preventDefault(); document.getElementById('vendor-logout-form').submit();">
                <i class="feather-log-out"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
    <form id="vendor-logout-form" action="{{ url('vendor/logout') }}" method="get" class="d-none">
        @csrf
    </form>
</div>
