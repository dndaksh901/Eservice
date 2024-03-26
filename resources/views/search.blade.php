@extends('layouts.main')

<style>
    .error{
        color:red;
        font-weight: 600;
        font-size: 0.7rem;
    }
    @media only screen and (max-width: 460px) {

    #filter-section{
        display: none;
    }
}
</style>
@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Search</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ isset($search_occupation) ? $search_occupation->occupation_name : 'No Found' }},
                                {{ $city }}, {{ $state }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="list-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 theiaStickySidebar">
                    <div class="listings-sidebar">
                        <div class="card ">
                            <h4 class="filter-section">
                                <img src="{{ asset('assets/img/details-icon.svg') }}" alt="details-icon" />
                                Filter
                            </h4>
                            <div id="filter-section">
                                <div class="filter-content looking-input form-group">
                                    <input type="text" class="form-control" placeholder="What are you looking for?"
                                        id="search-text" onblur="searchworker()" />
                                </div>

                                <div class="filter-content form-group amenities">
                                    <h4>Occupations</h4>
                                    <ul>
                                        @foreach ($occupations as $occupation)
                                            <li>
                                                <label class="custom_check">
                                                    <input type="radio" id="occupation_id.{{ $occupation->id }}"
                                                        name="occupation_id" value="{{ $occupation->slug }}"
                                                        {{ isset($search_occupation) && $search_occupation->slug == $occupation->slug ? 'checked' : '' }} />
                                                    <span class="checkmark"></span> {{ $occupation->occupation_name }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{-- <div class="filter-content form-group amenities radius">
                                    <div class="slidecontainer">
                                        <div class="slider-info">
                                            <h4>Radius</h4>
                                            <div class="demo"><span>50</span> Radius</div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="filter-range">
                                            <input type="text" class="input-range" />
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="filter-content amenities mb-0">
                                    <h4>Price Range</h4>
                                    <div class="form-group mb-0">
                                        <input type="number" class="form-control" placeholder="Min" max="50000" id="min_price" name="min_price" value="{{ $min_price }}" />
                                        <input type="number" class="form-control me-0" placeholder="Max" max="50000" id="max_price" name="max_price" value="{{ $max_price }}"/>
                                    </div>
                                    <div class="error" id="price_error"></div>
                                    <div class="search-btn">
                                        <button class="btn btn-primary" type="button"  onclick="filterButton('submit')">
                                            <i class="fa fa-search" aria-hidden="true"></i> Search
                                        </button>
                                        <button class="btn btn-reset mb-0" type="button"  onclick="resetButton('reset')">
                                            <i class="fas fa-light fa-arrow-rotate-right"></i>
                                            Reset Filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="row sorting-div">
                        <div class="col-lg-4 col-md-4 col-sm-4 align-items-center d-flex">
                            <div class="count-search">
                                <p>Showing <span>{{($profiles->currentpage()-1)*$profiles->perpage()+1}} to {{$profiles->currentpage()*$profiles->perpage()}}</span> of {{$profiles->total()}} Results</p>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 align-items-center">
                            {{-- <div class="sortbyset">
                                <span class="sortbytitle">Sort by</span>
                                <div class="sorting-select">
                                    <select class="form-control select" name="filter" id="price-filter">
                                        <option value="default">Default</option>
                                        <option value="low">Price Low to High</option>
                                        <option value="high">Price High to Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid-listview">
                                <ul>
                                    <li>
                                        <a href="listing-list-sidebar.html">
                                            <i class="feather-list"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="listing-grid-sidebar.html" class="active">
                                            <i class="feather-grid"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                    <div class="blog-listview">
                        @if(isset($profiles))
                        @forelse ($profiles as $key=>$profile)
                            <div class="card">

                                <div class="blog-widget">
                                    <div class="blog-img">
                                        <a href="/">
                                            <img src="{{ asset('vendor/vendor_image/'.$profile->vendor->avatar ?? 'avatar.jpg' )}}" class="img-fluid" alt="blog-img">
                                        </a>

                                        <div class="fav-item">

                                            {{-- <span class="Featured-text">Featured</span> --}}
                                            @if(Auth::guard('web')->check() && !empty($profile->favorite))
                                            <a href="javascript:void(0)" class="fav-icon selected" onclick="fav('del',{{$profile->id}},{{$profile->vendor_id}},{{ Auth::id() }})">
                                                <i class="feather-heart"></i>
                                            </a>
                                            @elseif(Auth::guard('web')->check() && empty($profile->favorite))
                                            <a href="javascript:void(0)" class="fav-icon" onclick="fav('fav',{{$profile->id}},{{$profile->vendor_id}},{{ Auth::id() }})">
                                                <i class="feather-heart"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="bloglist-content">
                                        <div class="card-body">
                                            <div class="blogfeaturelink">
                                                {{-- <div class="blog-features">
                                                    <a href="javascript:void(0);"><span>  {!! $profile->profile_status == 1 ? '<i
                                                        class="fa-regular fa-circle-stop text-success"></i> Available' : '<i
                                                        class="fa-regular fa-circle-stop"></i> Not Available' !!}</span></a>
                                                </div> --}}
                                                <div class="blog-author">
                                                    <div class="blog-author-img">
                                                        <img src="{{ asset('vendor/vendor_image/'.$profile->vendor->avatar ?? 'avatar.jpg' )}}" alt="author">
                                                    </div>
                                                    <a href="javascript:void(0);">{{ $profile->experience_year }} Years, {{ $profile->experience_month }} Months</a>
                                                </div>
                                            </div>
                                            <h6>{{ $profile->vendor->name ?? $profile->vendor->username }}</h6>
                                            <div class="blog-location-details">
                                                <div class="location-info">
                                                    <i class="feather-map-pin"></i> {{ $profile->city->name ?? '' }},{{ $profile->state->name ?? '' }}
                                                </div>

                                               @if(Auth::guard('vendor')->check() || Auth::check())
                                                <div class="location-info">
                                                    <i class="feather-phone-call"></i> <a href="tel:{{ $profile->vendor->mobile }}" >{{ $profile->vendor->mobile }}</a>
                                                </div>
                                                <div class="location-info">
                                                    <i class="feather-mail"></i> <a href="mailto:{{ $profile->vendor->email }}">{{ $profile->vendor->email }}</a>
                                                </div>
                                                @endif

                                            </div>
                                            <p class="ratings">
                                                <span>{{ number_format($profile->rating, 1) }}</span> ( 50 Reviews )
                                            </p>
                                            <div class="amount-details">
                                                <div class="amount">
                                                    <span class="validrate">₹ {{ $profile->price_per_hour }}</span>
                                                    <span>₹ {{ $profile->price_per_hour + rand(10,100) }}</span>
                                                </div>
                                                @if(Auth::guard('admin')->check())
                                                <a href="{{ url('login') }}">View details</a>
                                                @elseif(Auth::guard('vendor')->check())
                                                <a href="{{ url('/vendor-profile/'.$profile->id) }}">View details</a>
                                                @elseif(Auth::guard('web')->check())
                                                <a href="{{ url('/vendor-profile/'.$profile->id) }}">View details</a>
                                                @else
                                                <a href="{{ url('login') }}">View details</a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <h4>No Result Found<h4>
                        @endforelse
                        @endif

                        <div class="blog-pagination">
                            @if ($profiles->hasPages())
                            <nav>
                                <ul class="pagination">
                                    @if ($profiles->onFirstPage())
                                    <li class="page-item previtem disabled">
                                        <a class="page-link" href="#"
                                        tabindex="-1"><i class="fas fa-regular fa-arrow-left"></i>
                                            Prev</a>
                                    </li>
                                    @else
                                    <li class="page-item previtem">
                                        <a class="page-link"
                                        href="{{ $profiles->previousPageUrl() }}"><i class="fas fa-regular fa-arrow-left"></i>
                                              Prev</a>
                                      </li>
                                    @endif

                                    <li class="justify-content-center pagination-center">
                                        <div class="pagelink">
                                            <ul>
                                    @foreach ($profiles as $element)
                                        @if (is_string($element))
                                        <li class="page-item disabled">{{ $element }}</li>
                                        @endif

                                        @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                        <li class="page-item active">
                                            <a class="page-link">{{ $page }}</a>
                                        </li>
                                        @else
                                        <li class="page-item">
                                            <a class="page-link"
                                            href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </li>
                                    @if($profiles->hasMorePages())
                                    <li class="page-item nextlink">
                                        <a class="page-link" href="{{ $profiles->nextPageUrl() }}">Next <i
                                                class="fas fa-regular fa-arrow-right"></i></a>
                                    </li>
                                    @else
                                    <li class="page-item nextlink disabled">
                                        <a class="page-link" href="#">Next <i
                                                class="fas fa-regular fa-arrow-right"></i></a>
                                    </li>
                                    @endif
                                </ul>
                            </nav>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var location_data = JSON.parse(localStorage.getItem('currentLocation'));

            /*filter function start */

            function filterButton($btn){
                $('#price_error').empty();
                let occupation =  $('input[name="occupation_id"]:checked').val();
                let state = "{{ $state }}" ?? location_data.regionName;
                let city = "{{ $city }}" ?? location_data.cityName;
                let min_price = Number($('#min_price').val());
                let max_price = Number($('#max_price').val());

                if(!min_price){
                    min_price = 0;
                }
                if(!max_price){
                    max_price = 1000;
                }

                if(max_price < min_price){
                    $('#price_error').text(`Min price can not be greater than Max price.`)
                }
                let url = "{{ url('category') }}/" + occupation + '/' + city + '/' + state +'/' +min_price +'/' +max_price;
                window.location.href = url;
            }

            function resetButton($btn){
                $('#price_error').empty();
                let occupation =  $('input[name="occupation_id"]:checked').val();
                let state = "{{ $state }}" ?? location_data.regionName;
                let city = "{{ $city }}" ?? location_data.cityName;

                let url = "{{ url('search') }}/" + occupation + '/' + city + '/' + state;
                window.location.href = url;
            }

        $(document).ready(function() {
            var newWindowWidth = $(window).width();
            if (newWindowWidth < 461) {
                $(".filter-section").click(function(){
                    $("#filter-section").fadeToggle('2000');

                });
            }

     });


     function fav(status,profile_id,vendor_id,user_id){
alert(status);
                $.ajax({
                    url:"{{ url('favorite') }}",
                    type:"post",
                    data:{status,profile_id,vendor_id,user_id,'_token':"{{ csrf_token() }}"},
                    success:function(data){
                        console.log(data);
                        if(data == 1){
                            window.location.reload();
                        }
                    }
                });
}
        $('#search-text').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                console.log(event);
                return false;
            }
        });
        $('#price-filter').onchange(function(event) {
            let price_filter = $(this).val();
                console.log(event);


        });

        function searchworker() {
            let occupation = $('#search-text').val();
            if (occupation.length < 3) {
                $('#search-btn').attr('disabled', 'disabled');
                return false;
            } else {
                $('#search-btn').removeAttr("disabled");
            }

            let state = "{{ $state }}" ?? location_data.regionName;
            let city = "{{ $city }}" ?? location_data.cityName;
            let url = "{{ url('search') }}/" + occupation + '/' + city + '/' +state;
            window.location.href = url;
        }
    </script>
@endpush
