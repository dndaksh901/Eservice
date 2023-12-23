@extends('layouts.main')
@section('content')
    <style>
        .error-message {
            color: #D8000C;
            background-image: url('https://i.imgur.com/GnyDvKN.png');
            background-repeat: no-repeat;
            background-size: contain;
            display: none;
        }

        .err-text {
            font-size: 1rem;
            margin: 1.8rem;
            font-weight: 500;
        }

        #search-text {
            display: none;
        }

        .select2-results__option,
        #select2-city_id-container {
            text-transform: capitalize;
        }

        @media only screen and (max-width: 600px) {
            #search-text {
                display: block;
            }
        }
    </style>

    <section class="banner-section banner-five">
        <div class="container">
            <div class="home-banner">
                <div class="row align-items-center">
                    <div class="col-lg-12 mx-auto">
                        <div class="section-search aos" data-aos="fade-up">
                            <h1>SkilledWorker - The Experts You Need</h1>
                            <p>Providing skilled workers for all your needs</p>
                            <div class="search-box">
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif
                                <form id="search-form" class="form-block d-flex">

                                    <div class="search-input line">
                                        <div class="form-group mb-0">
                                            <div class="group-img">
                                                <select class="form-control select category-select" name="occupation_id"
                                                    id="occupation_id">
                                                    <option value="" disabled hidden @selected(true)>
                                                        Select Expert *</option>
                                                    @foreach ($data['occupations'] as $occupation)
                                                        <option value="{{ $occupation->occupation_name }}">
                                                            {{ $occupation->occupation_name }}</option>
                                                    @endforeach
                                                </select>
                                                <i class="feather-user"></i>
                                            </div>
                                        </div>
                                        <div class="error-message"><span class="err-text" id="err-occupation">Select
                                                Occupation</span></div>
                                    </div>
                                    <div class="search-input">
                                        <div class="form-group mb-0">
                                            <div class="group-img">
                                                <select class="form-control select state-select" name="state_id"
                                                    id="state_id" onchange="stateChange(this.value)">
                                                    <option value="" disabled @selected(true)
                                                        style="color:#999">
                                                        Select State</option>
                                                    @foreach ($data['states'] as $state)
                                                        <option value="{{ $state->name }}">{{ ucfirst($state->name) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <i class="feather-map-pin"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-input">
                                        <div class="form-group mb-0">
                                            <div class="group-img">
                                                <select class="form-control select city-select" name="city_id"
                                                    id="city_id">
                                                    <option value="" disabled hidden @selected(true)
                                                        style="color:#999">
                                                        Select City</option>
                                                </select>
                                                <i class="feather-map-pin"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="search-btn">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fa fa-search" aria-hidden="true"></i><span id="search-text"> Search
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="category-five-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-heading heading-five aos" data-aos="fade-up">
                        <h2>Our Categories</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="category-items text-center">
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/doctor.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Doctor</h6>
                                    {{-- <p>09 Ads</p> --}}
                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/designer.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Interior Designer</h6>

                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/electrician.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Electrician</h6>

                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/painter.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Painter</h6>
                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/teacher.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Tutor</h6>

                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/plumber.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Plumber</h6>

                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="category-items cate-row2">
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/builder.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Stonemason</h6>

                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/driver.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Personal Driver</h6>

                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/security.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Security Guard</h6>
                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/labor.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Labor</h6>
                                </div>
                            </div>
                        </li>
                        <li class="aos" data-aos="fade-up">
                            <div class="categories-box">
                                <div class="categories-info">
                                    <span><img src="{{ asset('assets/icon/automation.png') }}" class="img-fluid"
                                            alt="img"></span>
                                    <h6>Home Automation</h6>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>


    {{-- <section class="business-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-heading heading-five aos" data-aos="fade-up">
                        <h2>Trending Business Places</h2>
                    </div>
                </div>
            </div>
            <div class="owl-carousel business-slider grid-view">
                <div class="card business-card aos" data-aos="fade-up">
                    <div class="blog-widget">
                        <div class="blog-img">
                            <a href="service-details.html">
                                <img src="assets/img/business/business-01.jpg" class="img-fluid" alt="blog-img">
                            </a>
                            <div class="fav-item  justify-content-end">
                                <a href="javascript:void(0)" class="fav-icon">
                                    <i class="feather-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bloglist-content">
                            <div class="card-body">
                                <span class="Featured-text">Featured</span>
                                <div class="grid-author">
                                    <img src="assets/img/profiles/avatar-03.jpg" alt="author">
                                </div>
                                <div class="blogfeaturelink">
                                    <div class="blog-features">
                                        <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                                Restaurant</span></a>
                                    </div>
                                    <div class="blog-author text-end">
                                        <span><i class="feather-map-pin"></i> Paris</span>
                                    </div>
                                </div>
                                <h6><a href="service-details.html">Mattone Restaurant</a></h6>
                                <div class="amount-details">
                                    <div class="amount">
                                        <span class="validrate">$350</span>
                                        <span>$450</span>
                                    </div>
                                    <div class="ratings">
                                        <span>4.7</span> (50)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card business-card aos" data-aos="fade-up">
                    <div class="blog-widget">
                        <div class="blog-img">
                            <a href="service-details.html">
                                <img src="assets/img/business/business-02.jpg" class="img-fluid" alt="blog-img">
                            </a>
                            <div class="fav-item  justify-content-end">
                                <a href="javascript:void(0)" class="fav-icon">
                                    <i class="feather-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bloglist-content">
                            <div class="card-body">
                                <span class="Featured-text">Featured</span>
                                <div class="grid-author">
                                    <img src="assets/img/profiles/avatar-02.jpg" alt="author">
                                </div>
                                <div class="blogfeaturelink">
                                    <div class="blog-features">
                                        <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                                Fitness</span></a>
                                    </div>
                                    <div class="blog-author text-end">
                                        <span><i class="feather-map-pin"></i> New York</span>
                                    </div>
                                </div>
                                <h6><a href="service-details.html">Gym Equipment</a></h6>
                                <div class="amount-details">
                                    <div class="amount">
                                        <span class="validrate">$370</span>
                                        <span>$470</span>
                                    </div>
                                    <div class="ratings">
                                        <span>4.7</span> (50)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card business-card aos" data-aos="fade-up">
                    <div class="blog-widget">
                        <div class="blog-img">
                            <a href="service-details.html">
                                <img src="assets/img/business/business-03.jpg" class="img-fluid" alt="blog-img">
                            </a>
                            <div class="fav-item  justify-content-end">
                                <a href="javascript:void(0)" class="fav-icon">
                                    <i class="feather-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bloglist-content">
                            <div class="card-body">
                                <span class="Featured-text">Featured</span>
                                <div class="grid-author">
                                    <img src="assets/img/profiles/avatar-04.jpg" alt="author">
                                </div>
                                <div class="blogfeaturelink">
                                    <div class="blog-features">
                                        <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                                Beauty Care</span></a>
                                    </div>
                                    <div class="blog-author text-end">
                                        <span><i class="feather-map-pin"></i> Australia</span>
                                    </div>
                                </div>
                                <h6><a href="service-details.html">Beauty Parlour</a></h6>
                                <div class="amount-details">
                                    <div class="amount">
                                        <span class="validrate">$300</span>
                                        <span>$450</span>
                                    </div>
                                    <div class="ratings">
                                        <span>4.7</span> (50)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card business-card aos" data-aos="fade-up">
                    <div class="blog-widget">
                        <div class="blog-img">
                            <a href="service-details.html">
                                <img src="assets/img/business/business-04.jpg" class="img-fluid" alt="blog-img">
                            </a>
                            <div class="fav-item  justify-content-end">
                                <a href="javascript:void(0)" class="fav-icon">
                                    <i class="feather-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bloglist-content">
                            <div class="card-body">
                                <span class="Featured-text">Featured</span>
                                <div class="grid-author">
                                    <img src="assets/img/profiles/avatar-05.jpg" alt="author">
                                </div>
                                <div class="blogfeaturelink">
                                    <div class="blog-features">
                                        <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                                Shopping</span></a>
                                    </div>
                                    <div class="blog-author text-end">
                                        <span><i class="feather-map-pin"></i> Texas</span>
                                    </div>
                                </div>
                                <h6><a href="service-details.html">Shop Mall</a></h6>
                                <div class="amount-details">
                                    <div class="amount">
                                        <span class="validrate">$250</span>
                                        <span>$370</span>
                                    </div>
                                    <div class="ratings">
                                        <span>4.7</span> (50)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card business-card aos" data-aos="fade-up">
                    <div class="blog-widget">
                        <div class="blog-img">
                            <a href="service-details.html">
                                <img src="assets/img/business/business-02.jpg" class="img-fluid" alt="blog-img">
                            </a>
                            <div class="fav-item  justify-content-end">
                                <a href="javascript:void(0)" class="fav-icon">
                                    <i class="feather-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bloglist-content">
                            <div class="card-body">
                                <span class="Featured-text">Featured</span>
                                <div class="grid-author">
                                    <img src="assets/img/profiles/avatar-06.jpg" alt="author">
                                </div>
                                <div class="blogfeaturelink">
                                    <div class="blog-features">
                                        <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                                Gym</span></a>
                                    </div>
                                    <div class="blog-author text-end">
                                        <span><i class="feather-map-pin"></i> Florida</span>
                                    </div>
                                </div>
                                <h6><a href="service-details.html">Gym Equipment</a></h6>
                                <div class="amount-details">
                                    <div class="amount">
                                        <span class="validrate">$330</span>
                                        <span>$350</span>
                                    </div>
                                    <div class="ratings">
                                        <span>4.7</span> (50)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="feature-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading heading-five aos" data-aos="fade-up">
                        <h2>Featured Cities</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="city-box aos" data-aos="fade-up">
                        <div class="citi-img">
                            <a href="#">
                                <img src="assets/img/city/city-01.jpg" class="img-fluid" alt="img">
                            </a>
                        </div>
                        <div class="city-overlay">
                            <div class="city-name">
                                <h5>New York</h5>
                                <ul>
                                    <li><i class="feather-map-pin"></i> 10 Cities</li>
                                    <li><i class="feather-map"></i> 30+ Listing</li>
                                </ul>
                            </div>
                            <div class="rating d-flex">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="city-box aos" data-aos="fade-up">
                        <div class="citi-img">
                            <a href="#">
                                <img src="assets/img/city/city-02.jpg" class="img-fluid" alt="img">
                            </a>
                        </div>
                        <div class="city-overlay">
                            <div class="city-name">
                                <h5>London</h5>
                                <ul>
                                    <li><i class="feather-map-pin"></i> 15 Cities</li>
                                    <li><i class="feather-map"></i> 23+ Listing</li>
                                </ul>
                            </div>
                            <div class="rating d-flex">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="city-box aos" data-aos="fade-up">
                        <div class="citi-img">
                            <a href="#">
                                <img src="assets/img/city/city-03.jpg" class="img-fluid" alt="img">
                            </a>
                        </div>
                        <div class="city-overlay">
                            <div class="city-name">
                                <h5>Korea</h5>
                                <ul>
                                    <li><i class="feather-map-pin"></i> 12 Cities</li>
                                    <li><i class="feather-map"></i> 32+ Listing</li>
                                </ul>
                            </div>
                            <div class="rating d-flex">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="city-box aos" data-aos="fade-up">
                        <div class="citi-img">
                            <a href="#">
                                <img src="assets/img/city/city-04.jpg" class="img-fluid" alt="img">
                            </a>
                        </div>
                        <div class="city-overlay">
                            <div class="city-name">
                                <h5>Malaysia</h5>
                                <ul>
                                    <li><i class="feather-map-pin"></i> 18 Cities</li>
                                    <li><i class="feather-map"></i> 24+ Listing</li>
                                </ul>
                            </div>
                            <div class="rating d-flex">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    <section class="adventure-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-0 aos" data-aos="fade-up">
                    <div class="featuring-img">
                        <img src="{{ asset('assets/img/home/home-carpenter.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 aos" data-aos="fade-up">
                    <div class="adventure-info">
                        <div class="section-heading heading-five aos" data-aos="fade-up">
                            <h6>Why Choose Us</h6>
                            <h2>Its Time For New Adventures Escapes thrills & experiences</h2>
                        </div>
                        <div class="advent-info">
                            <p>SkilledWorker is dedicated to connecting businesses with highly skilled workers to meet their specific needs. With our vast network of professionals, we ensure that you have access to the right expertise for your projects. We prioritize quality and efficiency, providing reliable and experienced workers who can deliver outstanding results. At SkilledWorker, we understand the importance of finding the right talent, and we are committed to helping you succeed in your endeavors.</p>

                        </div>
                        <a href="{{ url('about-us') }}" class="btn btn-grey">About us <i
                                class="feather-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>


{{-- <section class="gallery-section-five">
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="section-heading heading-five aos" data-aos="fade-up">
                <h2>Best Place on Earth</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 aos" data-aos="fade-up">
            <div class="gal-wrap">
                <img src="assets/img/gallery/gallery-1.jpg" class="img-fluid" alt="img">
                <div class="city-overlay city-five-overlay">
                    <div class="city-name">
                        <h5>Oceania / Africa / US </h5>
                        <p>The collection of the Department of Africa.</p>
                    </div>
                    <div class="rating d-flex">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 aos" data-aos="fade-up">
            <div class="gal-wrap">
                <img src="assets/img/gallery/gallery-2.jpg" class="img-fluid" alt="img">
                <div class="city-overlay city-five-overlay">
                    <div class="city-name">
                        <h5>Oceania</h5>
                    </div>
                    <div class="rating d-flex">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="gal-wrap">
                <img src="assets/img/gallery/gallery-3.jpg" class="img-fluid" alt="img">
                <div class="city-overlay city-five-overlay">
                    <div class="city-name">
                        <h5>Africa </h5>
                    </div>
                    <div class="rating d-flex">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 aos" data-aos="fade-up">
            <div class="gal-wrap">
                <img src="assets/img/gallery/gallery-4.jpg" class="img-fluid" alt="img">
                <div class="city-overlay city-five-overlay">
                    <div class="city-name">
                        <h5>Oceania </h5>
                    </div>
                    <div class="rating d-flex">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="gal-wrap">
                <img src="assets/img/gallery/gallery-5.jpg" class="img-fluid" alt="img">
                <div class="city-overlay city-five-overlay">
                    <div class="city-name">
                        <h5>Africa / US </h5>
                    </div>
                    <div class="rating d-flex">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<section class="business-section">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="section-heading heading-five aos" data-aos="fade-up">
                <h2>Latest Ads</h2>
            </div>
        </div>
    </div>
    <div class="owl-carousel business-slider grid-view">
        <div class="card business-card aos" data-aos="fade-up">
            <div class="blog-widget">
                <div class="blog-img">
                    <a href="service-details.html">
                        <img src="assets/img/latest/latest-01.jpg" class="img-fluid" alt="blog-img">
                    </a>
                    <div class="fav-item  justify-content-end">
                        <a href="javascript:void(0)" class="fav-icon">
                            <i class="feather-heart"></i>
                        </a>
                    </div>
                </div>
                <div class="bloglist-content">
                    <div class="card-body">
                        <span class="Featured-text">Featured</span>
                        <div class="grid-author">
                            <img src="assets/img/profiles/avatar-03.jpg" alt="author">
                        </div>
                        <div class="blogfeaturelink">
                            <div class="blog-features">
                                <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                        Cinema</span></a>
                            </div>
                            <div class="blog-author text-end">
                                <span><i class="feather-map-pin"></i> Paris</span>
                            </div>
                        </div>
                        <h6><a href="service-details.html">Cinema</a></h6>
                        <div class="amount-details">
                            <div class="amount">
                                <span class="validrate">$350</span>
                                <span>$450</span>
                            </div>
                            <div class="ratings">
                                <span>4.7</span> (50)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card business-card aos" data-aos="fade-up">
            <div class="blog-widget">
                <div class="blog-img">
                    <a href="service-details.html">
                        <img src="assets/img/latest/latest-02.jpg" class="img-fluid" alt="blog-img">
                    </a>
                    <div class="fav-item  justify-content-end">
                        <a href="javascript:void(0)" class="fav-icon">
                            <i class="feather-heart"></i>
                        </a>
                    </div>
                </div>
                <div class="bloglist-content">
                    <div class="card-body">
                        <span class="Featured-text">Featured</span>
                        <div class="grid-author">
                            <img src="assets/img/profiles/avatar-02.jpg" alt="author">
                        </div>
                        <div class="blogfeaturelink">
                            <div class="blog-features">
                                <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                        Lodging</span></a>
                            </div>
                            <div class="blog-author text-end">
                                <span><i class="feather-map-pin"></i> New York</span>
                            </div>
                        </div>
                        <h6><a href="service-details.html">Lodging</a></h6>
                        <div class="amount-details">
                            <div class="amount">
                                <span class="validrate">$370</span>
                                <span>$470</span>
                            </div>
                            <div class="ratings">
                                <span>4.7</span> (50)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card business-card aos" data-aos="fade-up">
            <div class="blog-widget">
                <div class="blog-img">
                    <a href="service-details.html">
                        <img src="assets/img/latest/latest-03.jpg" class="img-fluid" alt="blog-img">
                    </a>
                    <div class="fav-item  justify-content-end">
                        <a href="javascript:void(0)" class="fav-icon">
                            <i class="feather-heart"></i>
                        </a>
                    </div>
                </div>
                <div class="bloglist-content">
                    <div class="card-body">
                        <span class="Featured-text">Featured</span>
                        <div class="grid-author">
                            <img src="assets/img/profiles/avatar-04.jpg" alt="author">
                        </div>
                        <div class="blogfeaturelink">
                            <div class="blog-features">
                                <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                        Outdoors</span></a>
                            </div>
                            <div class="blog-author text-end">
                                <span><i class="feather-map-pin"></i> Australia</span>
                            </div>
                        </div>
                        <h6><a href="service-details.html">Outdoors</a></h6>
                        <div class="amount-details">
                            <div class="amount">
                                <span class="validrate">$300</span>
                                <span>$450</span>
                            </div>
                            <div class="ratings">
                                <span>4.7</span> (50)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card business-card aos" data-aos="fade-up">
            <div class="blog-widget">
                <div class="blog-img">
                    <a href="service-details.html">
                        <img src="assets/img/latest/latest-04.jpg" class="img-fluid" alt="blog-img">
                    </a>
                    <div class="fav-item  justify-content-end">
                        <a href="javascript:void(0)" class="fav-icon">
                            <i class="feather-heart"></i>
                        </a>
                    </div>
                </div>
                <div class="bloglist-content">
                    <div class="card-body">
                        <span class="Featured-text">Featured</span>
                        <div class="grid-author">
                            <img src="assets/img/profiles/avatar-05.jpg" alt="author">
                        </div>
                        <div class="blogfeaturelink">
                            <div class="blog-features">
                                <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                        Automotive</span></a>
                            </div>
                            <div class="blog-author text-end">
                                <span><i class="feather-map-pin"></i> Texas</span>
                            </div>
                        </div>
                        <h6><a href="service-details.html">Automotive</a></h6>
                        <div class="amount-details">
                            <div class="amount">
                                <span class="validrate">$250</span>
                                <span>$370</span>
                            </div>
                            <div class="ratings">
                                <span>4.7</span> (50)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card business-card aos" data-aos="fade-up">
            <div class="blog-widget">
                <div class="blog-img">
                    <a href="service-details.html">
                        <img src="assets/img/latest/latest-02.jpg" class="img-fluid" alt="blog-img">
                    </a>
                    <div class="fav-item  justify-content-end">
                        <a href="javascript:void(0)" class="fav-icon">
                            <i class="feather-heart"></i>
                        </a>
                    </div>
                </div>
                <div class="bloglist-content">
                    <div class="card-body">
                        <span class="Featured-text">Featured</span>
                        <div class="grid-author">
                            <img src="assets/img/profiles/avatar-06.jpg" alt="author">
                        </div>
                        <div class="blogfeaturelink">
                            <div class="blog-features">
                                <a href="javascript:void(0)"><span> <i class="fa-regular fa-circle-stop"></i>
                                        Lodging</span></a>
                            </div>
                            <div class="blog-author text-end">
                                <span><i class="feather-map-pin"></i> Florida</span>
                            </div>
                        </div>
                        <h6><a href="service-details.html">Lodging</a></h6>
                        <div class="amount-details">
                            <div class="amount">
                                <span class="validrate">$330</span>
                                <span>$350</span>
                            </div>
                            <div class="ratings">
                                <span>4.7</span> (50)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<section class="pricing-plan">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="section-heading heading-five price-head-five aos" data-aos="fade-up">
                <h2>Our Pricing Plan</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 d-flex col-md-6">
            <div class="price-card price-three price-five flex-fill">
                <div class="price-head">
                    <div class="price-level">
                        <h6>Intro</h6>
                    </div>
                </div>
                <div class="price-body">
                    <ul>
                        <li class="active">Upload Video up to 720p Resolution</li>
                        <li class="inactive">Attachment & Post Scheduling</li>
                        <li class="inactive">Set your rates</li>
                        <li class="inactive">Exclusive Deals</li>
                        <li class="inactive">Advanced Statistics</li>
                    </ul>
                    <h4>$123 <span>/ month</span></h4>
                    <div>
                        <a href="login.html" class="btn viewdetails-btn">Choose Plan <i
                                class="feather-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex col-md-6">
            <div class="price-card price-three price-five flex-fill">
                <div class="price-head">
                    <div class="price-level">
                        <h6>Basic</h6>
                    </div>
                </div>
                <div class="price-body">
                    <ul>
                        <li class="active">Upload Video up to 720p Resolution</li>
                        <li class="active">Attachment & Post Scheduling</li>
                        <li class="active">Set your rates</li>
                        <li class="inactive">Exclusive Deals</li>
                        <li class="inactive">Advanced Statistics</li>
                    </ul>
                    <h4>$123 <span>/ month</span></h4>
                    <div>
                        <a href="login.html" class="btn viewdetails-btn">Choose Plan <i
                                class="feather-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex col-md-6">
            <div class="price-card price-three price-five flex-fill active">
                <div class="price-head">
                    <div class="price-level">
                        <h6>Popular</h6>
                        <span>Save $40</span>
                    </div>
                </div>
                <div class="price-body">
                    <ul>
                        <li class="active">Upload Video up to 720p Resolution</li>
                        <li class="active">Attachment & Post Scheduling</li>
                        <li class="active">Set your rates</li>
                        <li class="active">Exclusive Deals</li>
                        <li class="inactive">Advanced Statistics</li>
                    </ul>
                    <h4>$123 <span>/ month</span></h4>
                    <div>
                        <a href="login.html" class="btn viewdetails-btn">Choose Plan <i
                                class="feather-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 d-flex col-md-6">
            <div class="price-card price-three price-five flex-fill">
                <div class="price-head">
                    <div class="price-level">
                        <h6>Enterprise</h6>
                    </div>
                </div>
                <div class="price-body">
                    <ul>
                        <li class="active">Upload Video up to 720p Resolution</li>
                        <li class="active">Attachment & Post Scheduling</li>
                        <li class="active">Set your rates</li>
                        <li class="active">Exclusive Deals</li>
                        <li class="active">Advanced Statistics</li>
                    </ul>
                    <h4>$123 <span>/ month</span></h4>
                    <div>
                        <a href="login.html" class="btn viewdetails-btn">Choose Plan <i
                                class="feather-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<section class="testimonial-five-section">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="section-heading heading-five aos" data-aos="fade-up">
                <h2>Our Customer’s Says</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="owl-carousel testi-five-slider">
                <div class="testimonial-info testi-four testi-five aos" data-aos="fade-up">
                    <div class="testimonialslider-content">
                        <span><i class="fa-solid fa-quote-left"></i></span>
                        <h6>It was a wonderful experience</h6>
                        <p>Omnis totam molestiae delectus nemo alias nesciunt harum et. Nobis dolorum excepturi quod
                            vel. Sunt est qui ab non dolores repellat rem impedit dolores. Ut ea rerum cum eum.
                            Alias dolores tempore illo accusantium est et voluptatem voluptas</p>
                    </div>
                    <div class="testimonialslider-heading d-flex">
                        <div class="testi-img">
                            <img src="assets/img/testimonial-1.jpg" class="img-fluid" alt="testi-img">
                        </div>
                        <div class="testi-author">
                            <h6>Dev</h6>
                        </div>
                    </div>
                </div>
                <div class="testimonial-info testi-four testi-five aos" data-aos="fade-up">
                    <div class="testimonialslider-content">
                        <span><i class="fa-solid fa-quote-left"></i></span>
                        <h6>It was a very good experience</h6>
                        <p>Omnis totam molestiae delectus nemo alias nesciunt harum et. Nobis dolorum excepturi quod
                            vel. Sunt est qui ab non dolores repellat rem impedit dolores. Ut ea rerum cum eum.
                            Alias dolores tempore illo accusantium est et voluptatem voluptas</p>
                    </div>
                    <div class="testimonialslider-heading d-flex">
                        <div class="testi-img">
                            <img src="assets/img/testimonial-2.jpg" class="img-fluid" alt="testi-img">
                        </div>
                        <div class="testi-author">
                            <h6>Esther Hills</h6>
                        </div>
                    </div>
                </div>
                <div class="testimonial-info testi-four testi-five aos" data-aos="fade-up">
                    <div class="testimonialslider-content">
                        <span><i class="fa-solid fa-quote-left"></i></span>
                        <h6>It was a good experience</h6>
                        <p>Omnis totam molestiae delectus nemo alias nesciunt harum et. Nobis dolorum excepturi quod
                            vel. Sunt est qui ab non dolores repellat rem impedit dolores. Ut ea rerum cum eum.
                            Alias dolores tempore illo accusantium est et voluptatem voluptas</p>
                    </div>
                    <div class="testimonialslider-heading d-flex">
                        <div class="testi-img">
                            <img src="assets/img/profiles/avatar-06.jpg" class="img-fluid" alt="testi-img">
                        </div>
                        <div class="testi-author">
                            <h6>Hannah Schmitt</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<section class="latest-blog-five">
<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="section-heading heading-five aos" data-aos="fade-up">
                <h2>Our Latest Blog</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 d-flex aos" data-aos="fade-up">
            <div class="articles-grid w-100">
                <div class="articles-info">
                    <div class="articles-left">
                        <a href="javascript:void(0);">
                            <div class="articles-img">
                                <img src="assets/img/blog/blog-16.jpg" class="img-fluid" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="articles-right">
                        <div class="articles-content">
                            <ul class="articles-list nav">
                                <li>
                                    <i class="feather-user"></i> John Doe
                                </li>
                                <li>
                                    <i class="feather-calendar"></i> 13 Aug, 2023
                                </li>
                            </ul>
                            <h4>
                                <a href="javascript:void(0);">Lorem ipsum dolor amet, adipiscing ut labore </a>
                            </h4>
                            <p>Sed perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium</p>
                            <a href="javascript:void(0);" class="btn articles-read-more">Read More<i
                                    class="feather-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 d-flex aos" data-aos="fade-up">
            <div class="articles-grid w-100">
                <div class="articles-info">
                    <div class="articles-left">
                        <a href="javascript:void(0);">
                            <div class="articles-img">
                                <img src="assets/img/blog/blog-17.jpg" class="img-fluid" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="articles-right">
                        <div class="articles-content">
                            <ul class="articles-list nav">
                                <li>
                                    <i class="feather-user"></i> Darren Elder
                                </li>
                                <li>
                                    <i class="feather-calendar"></i> 10 Sep, 2023
                                </li>
                            </ul>
                            <h4>
                                <a href="javascript:void(0);">Lorem ipsum dolor amet, adipiscing ut labore </a>
                            </h4>
                            <p>Sed perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium</p>
                            <a href="javascript:void(0);" class="btn articles-read-more">Read More<i
                                    class="feather-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 d-flex aos" data-aos="fade-up">
            <div class="articles-grid w-100">
                <div class="articles-info">
                    <div class="articles-left">
                        <a href="javascript:void(0);">
                            <div class="articles-img">
                                <img src="assets/img/blog/blog-18.jpg" class="img-fluid" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="articles-right">
                        <div class="articles-content">
                            <ul class="articles-list nav">
                                <li>
                                    <i class="feather-user"></i> Ruby Perrin
                                </li>
                                <li>
                                    <i class="feather-calendar"></i> 30 Oct, 2023
                                </li>
                            </ul>
                            <h4>
                                <a href="javascript:void(0);">Lorem ipsum dolor amet, adipiscing ut labore </a>
                            </h4>
                            <p>Sed perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                laudantium</p>
                            <a href="javascript:void(0);" class="btn articles-read-more">Read More<i
                                    class="feather-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 d-flex aos" data-aos="fade-up">
            <div class="articles-grid w-100">
                <div class="articles-info">
                    <div class="articles-left">
                        <a href="javascript:void(0);">
                            <div class="articles-img">
                                <img src="assets/img/blog/blog-19.jpg" class="img-fluid" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="articles-right">
                        <div class="articles-content">
                            <ul class="articles-list nav">
                                <li>
                                    <i class="feather-user"></i> John Doe
                                </li>
                                <li>
                                    <i class="feather-calendar"></i> 22 Sep 2023
                                </li>
                            </ul>
                            <h4>
                                <a href="javascript:void(0);">Lorem ipsum dolor consectetur adipiscing </a>
                            </h4>
                            <p>Sed perspiciatis unde omnis iste voluptatem accusantium doloremque laudantium, totam
                                rem aperiam</p>
                            <a href="javascript:void(0);" class="btn articles-read-more">Read More<i
                                    class="feather-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<section class="stay-tuned stay-turn-five">
<div class="container">
    <div class="stay-with-us">
        <h3>Stay Tuned With Us</h3>
        <p>Subcribe to our newletter and never miss our latest news and promotions. Our newsletter is sent once a
            week, every thursday.</p>
        <form>
            <div class="form-group">
                <div class="group-img">
                    <i class="feather-mail"></i>
                    <input type="text" class="form-control" placeholder="Enter Email Address">
                </div>
            </div>
            <button class="btn btn-primary" type="submit"> Subscribe</button>
        </form>
    </div>
</div>
</section> --}}


@endsection

@push('js')
    <script>
        function stateChange(selectedValue) {
            //make the ajax call
            $('select[name="city_id"]').html('');

            $.ajax({
                url: '{{ url('city-by-state-by-name') }}' + "/" + selectedValue,
                type: 'get',
                success: function(data) {

                    if (data.length > 0) {
                        $.each(data, function(id, locations) {
                            $('select[name="city_id"]').append($("<option></option>").attr("value",
                                locations.name).text(locations.name).addClass('capitalise'));
                        });
                    } else {
                        $('select[name="city_id"]').append(`<option>No City found</option>`);
                    }
                }
            });
        }

        $('#search-form').submit(function(e) {
            e.preventDefault();
            let location_data = JSON.parse(localStorage.getItem('currentLocation'));
            let occupation = $('#occupation_id').val();
            let state = $('#state_id').val();
            let city = $('#city_id').val();
            // console.log(location_data.regionCode);
            if (occupation == null) {
                $('.error-message').show();
                return false;
            } else {
                $('.error-message').hide();
            }

            if (state == null) {
                state = location_data.regionName;
                if (city == null) {
                    city = location_data.cityName;
                }
            }


            let url = "{{ url('search') }}/" + occupation + '/' + city + '/' + state;
            window.location.href = url;
        });


        $('#occupation_id').change(function() {
            let occupation = $('#occupation_id').val();
            if (occupation == null) {
                $('.error-message').show();
            } else {
                $('.error-message').hide();
            }
        })
    </script>
@endpush
