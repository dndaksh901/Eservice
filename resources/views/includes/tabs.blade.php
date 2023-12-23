<ul class="dashborad-menus">
    {{-- <li class="{{ request()->is('vendor/dashboard') ? 'active' : '' }}">
        <a href="{{ url('vendor/dashboard') }}">
            <i class="feather-grid"></i> <span>Dashboard</span>
        </a>
    </li> --}}
    <li class="{{ request()->is('vendor/profile') ? 'active' : '' }}">
        <a href="{{ url('vendor/profile') }}">
            <i class="fa-solid fa-user"></i> <span>Profile</span>
        </a>
    </li>
    <li class="{{ request()->is('vendor/profession') ? 'active' : '' }}">
        <a href="{{ url('vendor/profession') }}">
            <i class="fa-solid fa-user-tie"></i> <span>Profession</span>
        </a>
    </li>
    {{-- <li class="{{ request()->is('vendor/listing') ? 'active' : '' }}">
        <a href="{{ url('vendor/listing') }}">
            <i class="feather-list"></i> <span>My Listing</span>
        </a>
    </li> --}}

    <li class="{{ request()->is('vendor/message') ? 'active' : '' }}">
        <a href="{{ url('vendor/message') }}">
            <?php
               use App\Models\Notification;
                $unread=Notification::where('vendor_id', Auth::id())->where('is_read',0)->count(); ?>
            <i class="fa-solid fa-comment-dots"></i> <span>Messages {{ isset($unread) && $unread > 0 ? '('.$unread.')' : ''}}</span>
        </a>
    </li>
    {{-- <li class="{{ request()->is('vendor/reviews') ? 'active' : '' }}">
        <a href="{{ url('vendor/reviews') }}">
            <i class="fas fa-solid fa-star"></i> <span>Reviews</span>
        </a>
    </li> --}}
    <li>
        <a href="{{ url('vendor/logout') }}"
            onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"><i
                class="fas fa-light fa-circle-arrow-left"></i> <span>Logout</span></a>
    </li>
    <form id="logout-form" action="{{ url('vendor/logout') }}" method="get" class="d-none">
        @csrf
    </form>
</ul>
