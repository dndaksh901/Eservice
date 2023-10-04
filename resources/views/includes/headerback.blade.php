<header class="main_header">
    <nav class="navbar navbar-expand-md navbar-light primaryTopBar">
        <div class="container custom_container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('imgs/logo.webp') }}" srcset="{{ asset('imgs/logo.webp') }}" class="img-fluid brand_img" alt="Brand Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
                <i class="fas fa-bars togglerIcon"></i>
            </button>
            <div class="collapse navbar-collapse" id="topNavbar">
                <ul class="navbar-nav menuLists align-items-center">
                    <li class="nav-item top_under_submenu_logo">
                        <a class="nav-link" href="/">
                            <img src="{{ asset('imgs/logo-white.webp') }}" srcset="{{ asset('imgs/logo-white.webp') }}" class="img-fluid brand_img_submenu" alt="Brand Logo">
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                    </li>

                    <li class="nav-item dropdown">


                            @if (!Auth::guard('vendor')->check() && !Auth::check())

                                <a class="nav-link mx-2 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  Account
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>

                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ url('vendor/login') }}">Vendor Login</a>
                                            </li>


                                    </ul>

                                @endif

                            @if(Auth::guard('vendor')->check() )

                                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                              {{ Auth::guard('vendor')->user()->name }}
                                          </a>

                                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                              <a class="dropdown-item" href="{{ url('vendor/logout') }}"
                                                 onclick="event.preventDefault();
                                                               document.getElementById('logout-form').submit();">
                                                  {{ __('Logout') }}
                                              </a>

                                              <form id="logout-form" action="{{ url('vendor/logout') }}" method="get" class="d-none">
                                                  @csrf
                                              </form>
                                          </div>


                @elseif(Auth::check())

                                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                              {{ Auth::user()->name }}
                                          </a>

                                          <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                              <a class="dropdown-item" href="{{ route('logout') }}"
                                                 onclick="event.preventDefault();
                                                               document.getElementById('logout-form').submit();">
                                                  {{ __('Logout') }}
                                              </a>

                                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                  @csrf
                                              </form>
                                          </div>

                @endif
                                    {{-- <li><a class="dropdown-item" href="#">About Us</a></li>
                                    <li><a class="dropdown-item" href="#">Contact us</a></li> --}}


                    </li>

                </ul>

                <form class="top_search" action="{{ url('search') }}" method="post">
                    @csrf
                    <div class="form-group position-relative">
                        <input type="text" class="form-control search_main_menu" name="occupation" placeholder="search"/>
                        <button class="btn search_btn" type="submit"><i class="fas fa-search search_icon"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav social_icon">
                    <li class="nav-item">
                        <a class="nav-link social_links" href="https://twitter.com">
                            <i class="fab fa-twitter social_menu"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link social_links" href="https://facebook.com">
                            <i class="fab fa-facebook-f social_menu"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link social_links" href="https://instagram.com">
                            <i class="fab fa-instagram social_menu"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

