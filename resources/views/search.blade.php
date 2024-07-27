@extends('layouts.main')

@section('content')
<style>
    .card-link {
    display: block;
    color: inherit;
    text-decoration: none;
}

.card-link:hover .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.star-rating {
    display: inline-flex;
    color: #f5c518; /* Gold color for the stars */
}

.star-rating .feather-star {
    font-size: 16px;
    color: #e4e5e9; /* Gray color for empty stars */
}

.star-rating .feather-star.filled {
    color: #f5c518; /* Gold color for filled stars */
}

.rating-value {
    font-weight: bold;
    margin-left: 8px;
    font-size: 16px;
    color: #333;
}

</style>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Search</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">

                                <span><b>{{ isset($search_occupation) ? $search_occupation->occupation_name : 'Not Found' }}</b></span>
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
                        <div class="card">
                            <h4 class="filter-section">
                                <img src="{{ asset('assets/img/details-icon.svg') }}" alt="details-icon" />
                                Filter
                            </h4>
                            <div id="filter-section">
                                <div class="search-input line">
                                    <div class="form-group mb-0">
                                        <div class="group-img">
                                            <select class="form-control select category-select" name="occupation_id" id="occupation_id" required>
                                                <option value="" disabled hidden @selected(true)>Select Expert *</option>
                                                @foreach ($occupations as $occupation)
                                                    <option value="{{ $occupation->id }}" {{ $occupation_id == $occupation->id ? 'selected' : '' }}>
                                                        {{ $occupation->occupation_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="search-input">
                                    <div class="form-group mb-0 mt-4">
                                        <div class="group-img">
                                            <input id="autocomplete" placeholder="Enter your address" type="text" class="form-control" required/>
                                            <input type="hidden" id="latitude" name="latitude" value="{{ $latitude ?? '' }}">
                                            <input type="hidden" id="longitude" name="longitude" value="{{ $longitude ?? '' }}">
                                            <input id="city" name="city" type="hidden" class="form-control mt-2" placeholder="City" value="{{ $city ?? '' }}">
                                            <input id="state" name="state" type="hidden" class="form-control mt-2" placeholder="State" value="{{ $state ?? '' }}">
                                            <input id="country" name="country" type="hidden" class="form-control mt-2" placeholder="Country" value="{{ $country ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="search-input">
                                    <div class="form-group mb-0 mt-4">
                                        <select class="form-control select" name="radius" id="radius" required>
                                            <option value="5" {{ $radius == "5" || $radius == "" ? "selected" : '' }}>5 km</option>
                                            <option value="10" {{ $radius == "10" ? "selected" : '' }}>10 km</option>
                                            <option value="20" {{ $radius == "20" ? "selected" : '' }}>20 km</option>
                                            <option value="50" {{ $radius == "50" ? "selected" : '' }}>50 km</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="search-input">
                                    <div class="form-group mb-0 mt-4">
                                        <select class="form-control select" name="rating" id="rating" required>
                                            <option value="0" {{ $rating == "0" || $rating == "" ? "selected" : '' }}>Any Rating</option>
                                            <option value="1" {{ $rating == "1" ? "selected" : '' }}>1 Star & Above</option>
                                            <option value="2" {{ $rating == "2" ? "selected" : '' }}>2 Stars & Above</option>
                                            <option value="3" {{ $rating == "3" ? "selected" : '' }}>3 Stars & Above</option>
                                            <option value="4" {{ $rating == "4" ? "selected" : '' }}>4 Stars & Above</option>
                                            <option value="5" {{ $rating == "5" ? "selected" : '' }}>5 Stars</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Price Range --}}
                                <div class="filter-content amenities mb-0 mt-4">
                                    <h4>Price Range</h4>
                                    <div class="form-group mb-0">
                                        <input type="number" class="form-control" placeholder="Min" max="50000" id="min_price" name="min_price" value="{{ $min_price }}" />
                                        <input type="number" class="form-control me-0" placeholder="Max" max="50000" id="max_price" name="max_price" value="{{ $max_price }}" />
                                    </div>
                                    <div class="error" id="price_error"></div>
                                    <div class="search-btn">
                                        <button class="btn btn-primary" type="button" onclick="filterButton('submit')">
                                            <i class="fa fa-search" aria-hidden="true"></i> Search
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
                        <div class="col-lg-8 col-md-8 col-sm-12 align-items-center d-flex">
                            <p><b>Address: </b>{{ $city ?? 'City not specified' }},
                            {{ $state ?? 'State not specified' }},
                            {{ $country ?? 'Country not specified' }}</p>
                        </div>
                    </div>

                    @if($message)
                        <div class="alert alert-warning">
                            {{ $message }}
                        </div>
                    @else
                    <div class="blog-listview">
                        @if(isset($profiles))
                        @forelse ($profiles as $key=>$profile)
                        @php
                        if (Auth::guard('admin')->check()) {
                            $link = route('login');
                        } elseif (Auth::guard('vendor')->check() || Auth::guard('web')->check()) {
                            $link = route('vendor.detail', ['id' => $profile->id]);
                        } else {
                            $link = route('login');
                        }
                    @endphp
                        <a href="{{ $link }}" class="card-link">
                            <div class="card">
                                <div class="blog-widget">
                                    <div class="blog-img">

                                        <img src="{{ asset('vendor/vendor_image/'.$profile->vendor->avatar ?? 'avatar.jpg' )}}" class="img-fluid" alt="blog-img" oncontextmenu="return false;" >

                                        <div class="fav-item">
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
                                                    <i class="feather-map-pin"></i> {{ $profile->vendor->profile->address ?? '' }}
                                                </div>
                                                <div class="location-info">
                                                    <i class="feather-map-pin"></i> Distance: {{ round($profile->distance, 2) }} km
                                                </div>
                                                @if(Auth::guard('vendor')->check() || Auth::check())
                                                    <div class="location-info">
                                                        <i class="feather-phone-call"></i> <a href="tel:{{ $profile->vendor->mobile }}">{{ $profile->vendor->mobile }}</a>
                                                    </div>
                                                    <div class="location-info">
                                                        <i class="feather-mail"></i> <a href="mailto:{{ $profile->vendor->email }}">{{ $profile->vendor->email }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="ratings">
                                                <div class="star-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($profile->rating >= $i)
                                                            <i class="feather-star filled"></i>
                                                        @else
                                                            <i class="feather-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="rating-value">{{ number_format($profile->rating, 1) }}</span>
                                                ( 50 Reviews )
                                            </p>
                                            <div class="amount-details">
                                                <div class="amount">
                                                    <span class="validrate">₹ {{ $profile->price_per_hour }}</span>
                                                    <span>₹ {{ $profile->price_per_hour + rand(10, 100) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                            @empty
                                <p>No profiles found</p>
                            @endforelse

                            {{-- Pagination links --}}
                            <div class="pagination-wrapper">
                                {{ $profiles->links() }}
                            </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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

<script>
    var location_data = JSON.parse(localStorage.getItem('currentLocation'));

    /* Filter function start */
    function filterButton($btn) {
        $('#price_error').empty();
        let occupation_id = $('#occupation_id').val();
        let min_price = Number($('#min_price').val());
        let max_price = Number($('#max_price').val());
        let latitude = $("#latitude").val();
        let longitude = $("#longitude").val();
        let city = $("#city").val();
        let state = $("#state").val();
        let country = $("#country").val();
        let radius = $("#radius").val();  // Get the selected radius value
        let rating = $("#rating").val();

        if (!min_price) {
            min_price = 0;
        }
        if (!max_price) {
            max_price = 1000;
        }

        if (max_price < min_price) {
            $('#price_error').text(`Min price cannot be greater than Max price.`);
            return;
        }

        let url = "{{ url('search') }}?occupation_id=" + occupation_id + "&latitude=" + latitude + "&longitude=" + longitude + "&radius=" + radius + "&min_price=" + min_price + "&max_price=" + max_price + "&city=" + city + "&state=" + state + "&country=" + country+"&rating="+rating;
        window.location.href = url;
    }

    $(document).ready(function() {
        var newWindowWidth = $(window).width();
        if (newWindowWidth < 461) {
            $(".filter-section").click(function() {
                $("#filter-section").fadeToggle('2000');
            });
        }
    });

    function fav(status, profile_id, vendor_id, user_id) {
        $.ajax({
            url: "{{ url('favorite') }}",
            type: "post",
            data: { status, profile_id, vendor_id, user_id, '_token': "{{ csrf_token() }}" },
            success: function(data) {
                if (data == 1) {
                    window.location.reload();
                }
            }
        });
    }

    $('#search-text').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            return false;
        }
    });

    function searchworker() {
        let occupation = $('#search-text').val();
        if (occupation.length < 3) {
            $('#search-btn').attr('disabled', 'disabled');
            return false;
        } else {
            $('#search-btn').removeAttr("disabled");
        }

        let latitude = location_data.latitude;
        let longitude = location_data.longitude;
        let radius = 10;  // Set a default radius value

        let url = "{{ url('search') }}?occupation_id=" + occupation + "&latitude=" + latitude + "&longitude=" + longitude + "&radius=" + radius;
        window.location.href = url;
    }
</script>


@endpush
