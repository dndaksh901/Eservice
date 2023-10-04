@extends('layouts.app')

@section('content')
<style>

    .error-message{
		color: #D8000C;
		background-image: url('https://i.imgur.com/GnyDvKN.png');
        background-repeat: no-repeat;
        background-size: contain;
        display: none;
		}
    .err-text{
        font-size: 1rem;
        margin: 1.8rem;
        font-weight: 500;
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

    .select2-container .select2-selection--single {
    box-sizing: border-box;
    cursor: pointer;
    display: block;
    height: 50px;
    user-select: none;
    -webkit-user-select: none;
    border-radius: 50px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff;
    line-height: 50px;
    background: #097953;
    border-color: #097953;
    border-radius: 50px;
    padding-left: 30px;
    padding-right: 30px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 26px;
    position: absolute;
    top: 13px;
    right: 9px;
    width: 21px;
    /* z-index: 999; */
}
.select2-container--default.select2-container--open.select2-container--above .select2-selection--single, .select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple{
    background: #097953;
    border-color: #097953;
}
.select2-container--default.select2-container--open.select2-container--below .select2-selection--single,
.select2-container--open .select2-dropdown--below
{
    background: #097953;
}

.select2-container--default .select2-results__option--selected {
    background-color: #eec639;
}
.select2-results__options{
    color:#fff;
    background: #097953;
}
/* custom scrollbar */
::-webkit-scrollbar {
  width: 20px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #d6dee1;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #a8bbbf;
}
@media screen and (max-width:767px){
    .form-group.position-relative {
        margin:15px 0;
}
}
  </style>
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
                            @if (Auth::guard('vendor')->check() || Auth::check())
                            <a href="{{ url('about') }}" class="btn slider_button cs_btn">About Us</a>
                            @endif
                            @if (!Auth::guard('vendor')->check() && !Auth::check())
                            <a href="{{ url('login') }}" class="btn slider_button cs_btn">Make an account!</a>
                            @endif
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

                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endforeach
                 @endif

                {{-- <form class="contact_type_form" action="{{ url('search') }}" method="get"> --}}
                <form id="search-form">

                    <div class="row w-100 m-0">
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="form-group position-relative">
                                <select class="js-example-basic-single form-control form_top_field light_field" name="occupation_id" id="occupation_id">
                                    <option value="" disabled hidden @selected(true)>Select Expert *</option>
                                    @foreach ($data['occupations'] as $occupation)
                                    <option value="{{ $occupation->id }}">{{ $occupation->occupation_name }}</option>
                                    @endforeach
                                  </select>
                                <i class="fas fa-caret-down form_down_caret"></i>
                            </div>
                            <div class="error-message"><span class="err-text" id="err-occupation">Select Occupation</span></div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="form-group position-relative">
                                <select class="js-example-basic-single form-control form_top_field light_field" name="state_id" id="state_id" onchange="stateChange(this.value)" >
                                    <option value="" disabled hidden @selected(true)>Select State</option>
                                    @foreach ($data['states'] as $state )
                                        <option value="{{ $state->name }}">{{ $state->name }}</option>
                                    @endforeach
                                  </select>
                                  <i class="fas fa-caret-down form_down_caret"></i>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                            <div class="form-group position-relative">
                                <select class="js-example-basic-single form-control form_top_field light_field" name="city_id" id="city_id">
                                    <option value="" disabled hidden @selected(true)>Select City</option>
                                {{-- @foreach ($data['cities'] as $city)
                                    <option value="{{ $city->name }}">{{ $city->name }}</option>
                                @endforeach --}}
                                  </select>
                                  <i class="fas fa-caret-down form_down_caret"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row w-100 m-0">


                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 "></div>

                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 ">
                            <div class="form-group position-relative">
                                <input type="submit" class="btn submit_top_form w-100 p-2" value="search">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-12 "></div>

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
@endsection
@push('js')

    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
            var swiper = new Swiper(".mySwiper", {
                // direction: "vertical",
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

          // Select2 Options
                var $disabledResults = $(".js-example-basic-single");
                $disabledResults.select2({
                width: '100%'
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
window.onload = (event) => {
   $.ajax({
    url:"{{ url('ip-address') }}",
    type:'get',
    success:function(data){
        localStorage.removeItem("currentLocation");
        localStorage.setItem("currentLocation",JSON.stringify(data));
    }
   })
};

function stateChange(selectedValue) {
    //make the ajax call
      $('select[name="city_id"]').html('');

    $.ajax({
        url: '{{url("city-by-state-by-name")}}'+ "/"+selectedValue,
        type: 'get',
        success: function(data) {
            // console.log(data);
            // $('select[name="city_id"]').not(':first').empty();
            if(data.length > 0){
                $.each(data,function(id,locations){
              $('select[name="city_id"]').append($("<option></option>").attr("value",locations.name).text(locations.name));
             });
            }
            else{
                $('select[name="city_id"]').append(`<option>No City found</option>`);
            }
        }
    });
}

$('#search-form').submit(function(e){
    e.preventDefault();
   let location_data = JSON.parse(localStorage.getItem('currentLocation'));
   let occupation = $('#occupation_id').val();
   let state = $('#state_id').val();
   let city = $('#city_id').val();
// console.log(location_data.regionCode);
   if(occupation == null){
    $('.error-message').show();
    return false;
   }else{
    $('.error-message').hide();
   }

   if(state == null){
     state = location_data.regionName;
      if(city == null){
       city = location_data.cityName;
     }
   }


  let url ="{{ url('search') }}/"+occupation+'/'+city+'/'+state;
  window.location.href=url;
});


$('#occupation_id').change(function(){
    let occupation = $('#occupation_id').val();
    if(occupation == null){
    $('.error-message').show();
}else{
    $('.error-message').hide();
   }
})
    </script>

@endpush
