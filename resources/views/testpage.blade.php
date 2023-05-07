<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Welcome Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <!-- Demo styles -->
  <style>
    html,
    body {
      position: relative;
      height: 100%;
    }

    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    .swiper {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
    </head>
    <body>
        <header class="main_header">
            <nav class="navbar navbar-expand-md navbar-light primaryTopBar">
                <div class="container custom_container">
                    <a class="navbar-brand" href="index.html">
                        <img src="{{ asset('imgs/logo.webp') }}" srcset="{{ asset('imgs/logo.webp') }}" class="img-fluid brand_img" alt="Brand Logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
                        <i class="fas fa-bars togglerIcon"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="topNavbar">
                        <ul class="navbar-nav menuLists align-items-center">
                            <li class="nav-item top_under_submenu_logo">
                                <a class="nav-link" href="index.html">
                                    <img src="{{ asset('imgs/logo-white.webp') }}" srcset="{{ asset('imgs/logo-white.webp') }}" class="img-fluid brand_img_submenu" alt="Brand Logo">
                                </a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="index.html">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="features.html">Featues</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aboutus.html">About us</a>
                            </li>
                            <li class="nav-item breakpoint">
                                <button class="btn menu_breakpoint_btn" type="button">
                                    <i class="fas fa-ellipsis-vertical breakpoint_icons"></i>
                                </button>
                                <ul class="sub_menu navbar-nav submenuLists">
                                    <li class="nav-item child_menu_breakpoint">
                                        <a class="nav-link" href="rentabike.html">Rent a bike</a>
                                    </li>
                                    <li class="nav-item child_menu_breakpoint">
                                        <a class="nav-link" href="news.html">News</a>
                                    </li>
                                    <li class="nav-item child_menu_breakpoint">
                                        <a class="nav-link" href="contacts.html">Contacts</a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                        <form class="top_search" action="" method="post">
                            <div class="form-group position-relative">
                                <input type="text" class="form-control search_main_menu" placeholder="search"/>
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
        <div class="main_body_content">
            <section class="top-slider">
                <div class="snipperSlider">
                    <!--Swiper -->

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <div class="slider_content position-relative w-100">
                            <img src="{{ asset('imgs/sliders/slider1.jpg') }}" class="img-fluid slider_img w-100" alt="Main Image" />
                            <div class="text_content">
                                <div class="content_box">
                                    <h4 class="slider_hint">Welcome to our site</h4>
                                    <h2 class="Slider_title">Now it is open in your town</h2>
                                    <p class="slider_descitpion">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                                    </p>
                                    <a href="#" class="btn slider_button cs_btn">Make an account!</a>
                                </div>
                            </div>
                        </div>
                      </div>
                          <div class="swiper-slide">
                            <div class="slider_content position-relative w-100">
                            <img src="{{ asset('imgs/sliders/slider1.jpg') }}" class="img-fluid slider_img w-100" alt="Main Image" />
                            <div class="text_content">
                                <div class="content_box">
                                    <h4 class="slider_hint">Welcome to our site</h4>
                                    <h2 class="Slider_title">Now it is open in your town</h2>
                                    <p class="slider_descitpion">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled.
                                    </p>
                                    <a href="#" class="btn slider_button cs_btn">Make an account!</a>
                                </div>
                            </div>
                        </div>
                      </div>

                        </div>
                        <div class="swiper-pagination"></div>
                      </div>
                </div>
            </section>

            <section class="contact-form-top">
                <article class="container">

                    <div class="form_box">
                        <div class="form_title">
                            <h5 class="subtitle text-center">Find a service</h5>
                            <h3 class="title text-center text-white">Looking an experts?</h3>
                        </div>
                        <form class="contact_type_form">
                            <div class="row w-100 m-0">

                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="form-group position-relative">
                                        <select class="form-select form_top_field light_field">
                                            <option value="">Location</option>
                                            <option value="bklist">1 Bike List</option>
                                            <option value="mtr">2 str read</option>
                                        </select>
                                        <i class="fas fa-caret-down form_down_caret"></i>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="form-group position-relative">
                                        <select class="form-select form_top_field light_field">
                                            <option value="">Return City & Location</option>
                                            <option value="bklist">1 Bike List</option>
                                            <option value="mtr">2 str read</option>
                                        </select>
                                        <i class="fas fa-caret-down form_down_caret"></i>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="form-group position-relative">
                                        <select class="form-select form_top_field light_field">
                                            <option value="">Class</option>
                                            <option value="bklist">1 Bike List</option>
                                            <option value="mtr">2 str read</option>
                                        </select>
                                        <i class="fas fa-caret-down form_down_caret"></i>
                                    </div>
                                </div>

                            </div>

                            <div class="row w-100 m-0">

                                <div class="col-lg-2 col-md-6 col-sm-6 col-12 pe-1">
                                    <div class="form-group position-relative">
                                        <input type="date" class="form-control form_top_field" >
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-6 col-12 ">
                                    <div class="form-group position-relative">
                                        <input type="time" class="form-control form_top_field" value="">
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-6 col-12 pe-1">
                                    <div class="form-group position-relative">
                                        <input type="date" class="form-control form_top_field" >
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-6 col-sm-6 col-12 ">
                                    <div class="form-group position-relative">
                                        <input type="time" class="form-control form_top_field" >
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                    <div class="form-group position-relative">
                                        <input type="submit" class="btn submit_top_form w-100 p-2" value="search">
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                </article>
            </section>

            <section class="card_sliders">
                <article class="container">
                    <div class="section_heading">
                        <h5 class="subtitle text-center">WHAT WE OFFER</h5>
                        <h3 class="title text-center">Explore Our Bike Range</h3>
                    </div>
                    <div class="card_slider_box">
                        <div class="swiper cardSwiperSlider">
                            <div class="swiper-wrapper">

                                <div class="swiper-slide card_swipeSlide">
                                    <div class="card_box w-100 position-relative">
                                        <div class="card_top_header py-4">
                                            <img src="{{ asset('imgs/card_slider/slider_card_1.jpg') }}" class="img-fluid card_slider_img w-100" alt="Card Slider Main Image">
                                            <div class="cost_circle">
                                                <p class="fees mb-0"><span class="unit_format">$</span> <span class="fees_amount">25</span></p>
                                                <p class="subs_plan mb-0">per month</p>
                                            </div>
                                        </div>
                                        <div class="card_body_main pb-4">
                                            <h4 class="card_slider_title"><a href="#">B1 Bike Time</a></h4>
                                            <p class="card_slider_info">Road Bike</p>
                                            <button class="btn btn_card custom_btn">View Detail</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide card_swipeSlide">
                                    <div class="card_box w-100 position-relative">
                                        <div class="card_top_header py-4">
                                            <img src="{{ asset('imgs/card_slider/slider_card_1.jpg') }}" class="img-fluid card_slider_img w-100" alt="Card Slider Main Image">
                                            <div class="cost_circle">
                                                <p class="fees mb-0"><span class="unit_format">$</span> <span class="fees_amount">25</span></p>
                                                <p class="subs_plan mb-0">per month</p>
                                            </div>
                                        </div>
                                        <div class="card_body_main pb-4">
                                            <h4 class="card_slider_title"><a href="#">B1 Bike Time</a></h4>
                                            <p class="card_slider_info">Road Bike</p>
                                            <button class="btn btn_card custom_btn">View Detail</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide card_swipeSlide">
                                    <div class="card_box w-100 position-relative">
                                        <div class="card_top_header py-4">
                                            <img src="{{ asset('imgs/card_slider/slider_card_1.jpg') }}" class="img-fluid card_slider_img w-100" alt="Card Slider Main Image">
                                            <div class="cost_circle">
                                                <p class="fees mb-0"><span class="unit_format">$</span> <span class="fees_amount">25</span></p>
                                                <p class="subs_plan mb-0">per month</p>
                                            </div>
                                        </div>
                                        <div class="card_body_main pb-4">
                                            <h4 class="card_slider_title"><a href="#">B1 Bike Time</a></h4>
                                            <p class="card_slider_info">Road Bike</p>
                                            <button class="btn btn_card custom_btn">View Detail</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide card_swipeSlide">
                                    <div class="card_box w-100 position-relative">
                                        <div class="card_top_header py-4">
                                            <img src="{{ asset('imgs/card_slider/slider_card_1.jpg') }}" class="img-fluid card_slider_img w-100" alt="Card Slider Main Image">
                                            <div class="cost_circle">
                                                <p class="fees mb-0"><span class="unit_format">$</span> <span class="fees_amount">25</span></p>
                                                <p class="subs_plan mb-0">per month</p>
                                            </div>
                                        </div>
                                        <div class="card_body_main pb-4">
                                            <h4 class="card_slider_title"><a href="#">B1 Bike Time</a></h4>
                                            <p class="card_slider_info">Road Bike</p>
                                            <button class="btn btn_card custom_btn">View Detail</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide card_swipeSlide">
                                    <div class="card_box w-100 position-relative">
                                        <div class="card_top_header py-4">
                                            <img src="{{ asset('imgs/card_slider/slider_card_1.jpg') }}" class="img-fluid card_slider_img w-100" alt="Card Slider Main Image">
                                            <div class="cost_circle">
                                                <p class="fees mb-0"><span class="unit_format">$</span> <span class="fees_amount">25</span></p>
                                                <p class="subs_plan mb-0">per month</p>
                                            </div>
                                        </div>
                                        <div class="card_body_main pb-4">
                                            <h4 class="card_slider_title"><a href="#">B1 Bike Time</a></h4>
                                            <p class="card_slider_info">Road Bike</p>
                                            <button class="btn btn_card custom_btn">View Detail</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-button-next swipe_nav_btn"></div>
                            <div class="swiper-button-prev swipe_nav_btn"></div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="special_offer">
                <article class="container">
                    <div class="section_heading text-center">
                        <h5 class="subtitle text-center">WE HAVE SOMETHING SPECIAL FOR YOU!</h5>
                        <h3 class="title text-center mb-4 text-white">45,000 People Use TanTum Service</h3>
                        <div class="divider my-3"></div>
                        <p class="header_section_info text-center">Contact us now via our website & get a first-time 10% discount and enjoy it!</p>
                        <a class="btn custom_btn mx-auto">Contact Us Now</a>
                    </div>
                </article>
            </section>
        </div>
        <footer class="main_footer">

        </footer>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
         <script src="{{ asset('js/main.js') }}"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <script>
            var swiper = new Swiper(".mySwiper", {
                // direction: "vertical",
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });
        </script>
        <script>
            // Card Slider
            var swiper = new Swiper(".cardSwiperSlider", {
                slidesPerView: 3,
                spaceBetween: 30,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },// Responsive breakpoints
                breakpoints: {
                    // when window width is >= 100px
                    100: {
                    slidesPerView: 1,
                    spaceBetween: 20
                    },
                    // when window width is >= 480px
                    480: {
                    slidesPerView: 2,
                    spaceBetween: 30
                    },
                    // when window width is >= 640px
                    640: {
                    slidesPerView: 2,
                    spaceBetween: 40
                    },
                    // when window width is >= 992
                    992: {
                    slidesPerView: 3,
                    spaceBetween: 40
                    }
                }
            });
        </script>
    </body>
</html>
