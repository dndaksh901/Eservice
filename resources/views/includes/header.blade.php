<header class="header header-four">
    <div class="container">
        <nav class="navbar navbar-expand-lg header-nav">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
                <a href="/" class="navbar-brand logo">
                    <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                </a>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <a href="/" class="menu-logo">
                        <img src="{{ asset('assets/img/logo.svg') }}" class="img-fluid" alt="Logo">
                    </a>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
                </div>
                <ul class="main-nav">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="/">Home</a>

                    </li>
                    <li class="{{ request()->is('about-us') ? 'active' : '' }}">
                        <a href="{{ url('about-us') }}">About us</a>

                    </li>
                    {{-- <li class="{{ request()->is('categories') ? 'active' : '' }}">
                        <a href="{{ url('categories') }}">Categories</a>
                    </li> --}}
                    <li class="{{ request()->is('contact-us') ? 'active' : '' }}">
                        <a href="{{ url('contact-us') }}">Contact us</a>

                    </li>
                    {{-- <li class="has-submenu">
                        <a href="#">India <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="listing-grid.html">Listing Grid</a></li>
                            <li><a href="listing-grid-sidebar.html">Listing Grid Sidebar</a></li>
                            <li><a href="listing-list-sidebar.html">Listing List Sidebar</a></li>
                            <li><a href="listingmap-list.html">Listing List Map</a></li>
                            <li><a href="listingmap-grid.html">Listing Grid Map</a></li>
                        </ul>
                    </li> --}}
                   {{-- <li class="has-submenu">
                        <a href="#">Pages <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="service-details.html">Service Details </a></li>
                            <li><a href="pricing.html">Pricing</a></li>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="gallery.html">Gallery</a></li>
                            <li><a href="categories.html">Category</a></li>
                            <li><a href="howitworks.html">How it Works</a></li>
                            <li><a href="terms-condition.html">Terms & Conditions</a></li>
                            <li><a href="privacy-policy.html">Privacy Policy</a></li>
                            <li><a href="error-404.html">404 Error</a></li>
                            <li><a href="error-500.html">500 Error</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">User Pages <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="dashboard.html">Dashboard</a></li>
                            <li><a href="profile.html">Profile</a></li>
                            <li><a href="my-listing.html">My Listing</a></li>
                            <li><a href="bookmarks.html">Bookmarks</a></li>
                            <li><a href="messages.html">Messages</a></li>
                            <li><a href="reviews.html">Reviews</a></li>
                            <li><a href="add-listing.html">Add Listing</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#">Blog <i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li><a href="blog-list.html">Blog List</a></li>
                            <li><a href="blog-grid.html">Blog Grid</a></li>
                            <li><a href="blog-details.html">Blog Details</a></li>
                            <li><a href="blog-list-sidebar.html">Blog List Sidebar</a></li>
                            <li><a href="blog-grid-sidebar.html">Blog Grid Sidebar</a></li>
                        </ul>
                    </li> --}}
                    @if (!Auth::guard('vendor')->check() && !Auth::check() && !Auth::guard('admin')->check())
                        {{-- <li class="login-link">
                            <a href="{{ url('register') }}">register</a>
                        </li> --}}
                        <li class="login-link">
                            <a href="{{ url('login') }}">Log in</a>
                        </li>
                    @endif

                    @if (Auth::guard('vendor')->check())
                    <li class="has-submenu">
                            <a href="#" class="profile-userlink" >
                                <img src="{{ asset('vendor/vendor_image/' . Auth::guard('vendor')->user()->avatar) }}"
                                    alt="profile-image">
                                <span>{{ Auth::guard('vendor')->user()->name }}</span><i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="submenu">
                                <li><a  href="{{ url('vendor/profile') }}">Profile</a></li>

                                <li><a  href="{{ url('vendor/logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a></li>
                                <form id="logout-form" action="{{ url('vendor/logout') }}" method="get"
                                    class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    @elseif(Auth::check())
                    <li class="has-submenu">
                        <a href="#" class="profile-userlink" >

                            {{ Auth::guard('web')->user()->name }}<i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">

                            <li><a  href="{{ url('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ url('logout') }}" method="get"
                                class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @elseif (Auth::guard('admin')->check())
                    <li class="has-submenu">
                        <a href="#" class="profile-userlink" >

                            <span>{{ Auth::guard('admin')->user()->name }}</span><i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="submenu">
                            <li><a  href="{{ url('admin/dashboard') }}">Dashboard</a></li>

                            <li><a  href="{{ url('admin/logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a></li>
                            <form id="logout-form" action="{{ url('admin/logout') }}" method="get"
                                class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            @if (!Auth::guard('vendor')->check() && !Auth::check() && !Auth::guard('admin')->check())
                <ul class="nav header-navbar-rht nav">
                    <li class="nav-item">
                        <div class="cta-btn">
                            <a href="{{ url('login') }}" class="btn"><i class="feather-user"></i> Log in </a>
                            {{-- <a href="{{ url('register') }}" class="btn ms-1"> register</a> --}}
                        </div>
                    </li>
                </ul>
            @endif
            <!-- Country Select Dropdown -->
            <!-- <ul class="nav header-navbar-rht">
                <li class="nav-item">
                    <select id="header-country-select" class="form-select" aria-label="Country select">
                        <option selected>Select Country</option>
                    </select>
                </li>
            </ul> -->
        </nav>
    </div>
</header>
