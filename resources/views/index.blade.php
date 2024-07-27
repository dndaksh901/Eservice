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
                            <form id="search-form" action="{{ url('search') }}" method="get" class="form-block d-flex">

                                <div class="search-input line">
                                    <div class="form-group mb-0">
                                        <div class="group-img">
                                            <select class="form-control select category-select" name="occupation_id"
                                                id="occupation_id" required>
                                                <option value="" disabled hidden @selected(true)>
                                                    Select Expert *</option>
                                                @foreach ($data['occupations'] as $occupation)
                                                    <option value="{{ $occupation->id }}">
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
                                            <input id="autocomplete" placeholder="Enter your address" type="text" class="form-control" required/>
                                                <input type="hidden" id="latitude" name="latitude">
                                                <input type="hidden" id="longitude" name="longitude">
                                                <input id="city" name="city" type="hidden"></input>
                                                <input id="state"  name="state"type="hidden"></input>
                                                <input id="country"  name="country" type="hidden"></input>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-input">
                                    <div class="form-group mb-0">
                                        <select class="form-control select" name="radius" id="radius" required>
                                            <option value="5">5 km</option>
                                            <option value="10" selected>10 km</option>
                                            <option value="20">20 km</option>
                                            <option value="50">50 km</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="search-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <span id="search-text">Search</span>
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
                            <div onclick="chooseCategory('electrician')" class="categories-box">
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

@endsection

@push('js')
    <script>
        $('#occupation_id').change(function() {
            let occupation = $('#occupation_id').val();
            if (occupation == null) {
                $('.error-message').show();
            } else {
                $('.error-message').hide();
            }
        });


    </script>

   {{-- <script>
     function initAutocomplete() {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
            types: ['geocode']
        });
        autocomplete.setFields(['address_component', 'geometry']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            if (place.geometry) {
            console.log(place);
                $('#latitude').val(place.geometry.location.lat());
                $('#longitude').val(place.geometry.location.lng());
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script> --}}
@endpush
