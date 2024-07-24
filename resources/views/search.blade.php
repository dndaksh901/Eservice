@extends('layouts.main')

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
                                {{-- {{ $city }}, {{ $state }} --}}
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

                                <div class="search-input line">
                                    <div class="form-group mb-0">
                                        <div class="group-img">
                                            <select class="form-control select category-select" name="occupation_id"
                                                id="occupation_id" required>
                                                <option value="" disabled hidden @selected(true)>
                                                    Select Expert *</option>
                                                @foreach ($occupations  as $occupation)
                                                    <option value="{{ $occupation->id }}" {{ $occupation_id == $occupation->id ? 'selected' : ''}}>
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
                                                <input type="hidden" id="latitude" name="latitude">
                                                <input type="hidden" id="longitude" name="longitude">
                                        </div>
                                    </div>
                                </div>
                                {{-- Price Range --}}
                                <div class="filter-content amenities mb-0 mt-4">
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
                    </div>
                    @if($message)
                    <div class="alert alert-warning">
                        {{ $message }}
                    </div>
                    @else
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
                                                {{-- <div class="location-info">
                                                    <i class="feather-map-pin"></i> {{ $profile->city->name ?? '' }},{{ $profile->state->name ?? '' }}
                                                </div> --}}
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
                                                <a href="{{ url('/profile/'.$profile->id) }}">View details</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    function initAutocomplete() {
       var autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
           types: ['geocode']
       });
       autocomplete.setFields(['address_component', 'geometry']);

       autocomplete.addListener('place_changed', function() {
           var place = autocomplete.getPlace();
           if (place.geometry) {
               $('#latitude').val(place.geometry.location.lat());
               $('#longitude').val(place.geometry.location.lng());
           }
       });
   }
   google.maps.event.addDomListener(window, 'load', initAutocomplete);
</script>
<script>
    var location_data = JSON.parse(localStorage.getItem('currentLocation'));

    /* Filter function start */
    function filterButton($btn) {
        $('#price_error').empty();
        let occupation_id = $('#occupation_id').val();
        let min_price = Number($('#min_price').val());
        let max_price = Number($('#max_price').val());
        let latitude = "{{$latitude}}";
        let longitude = "{{$longitude}}";
        let radius = "{{$radius}}";  // Set a default radius value

        if (!min_price) {
            min_price = 0;
        }
        if (!max_price) {
            max_price = 1000;
        }

        if (max_price < min_price) {
            $('#price_error').text(`Min price can not be greater than Max price.`);
            return;
        }

        let url = "{{ url('search') }}?occupation_id=" + occupation_id + "&latitude=" + latitude + "&longitude=" + longitude + "&radius=" + radius + "&min_price=" + min_price + "&max_price=" + max_price;
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
