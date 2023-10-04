@extends('layouts.main')

@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Dashboard</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="dashboard-content">
        <div class="container">
            <div class="">
               @include('includes.tabs')
            </div>
            <div class="dashboard-details">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <div class="card dash-cards">
                            <div class="card-body">
                                <div class="dash-top-content">
                                    <div class="dashcard-img">
                                        <img src="{{ asset('assets/img/icons/verified.svg') }}" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Totals Jobs</h6>
                                    <h3 class="counter">100</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card dash-cards">
                            <div class="card-body">
                                <div class="dash-top-content">
                                    <div class="dashcard-img">
                                        <img src="{{ asset('assets/img/icons/rating.svg') }}" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Total Reviews</h6>
                                    <h3>{{$totalreviews ?? '0' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card dash-cards">
                            <div class="card-body">
                                <div class="dash-top-content">
                                    <div class="dashcard-img">
                                        <img src="{{ asset('assets/img/icons/chat.svg') }}" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Messages</h6>
                                    <h3>{{ $totalmessage ?? '0'}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="card dash-cards">
                            <div class="card-body">
                                <div class="dash-top-content">
                                    <div class="dashcard-img">
                                        <img src="assets/img/icons/bookmark.svg" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <div class="dash-widget-info">
                                    <h6>Likes</h6>
                                    <h3>30</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row dashboard-info">
                    <div class="col-lg-6 d-flex">
                        <div class="card dash-cards w-100">
                            <div class="card-header">
                                <h4>Page Views</h4>
                                <div class="card-dropdown">
                                    <ul>
                                        <li class="nav-item dropdown has-arrow logged-item">
                                            <a href="#" class="dropdown-toggle pageviews-link"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span>This week</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void();">Next Week</a>
                                                <a class="dropdown-item" href="javascript:void()">Last Month</a>
                                                <a class="dropdown-item" href="javascript:void()">Next Month</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="review-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-flex">
                        <div class="card dash-cards w-100">
                            <div class="card-header">
                                <h4>Visitor Review</h4>
                                {{-- <div class="card-dropdown">
                                    <ul>
                                        <li class="nav-item dropdown has-arrow logged-item">
                                            <a href="#" class="dropdown-toggle pageviews-link"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span>All Listing</span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void(0)">Next Week</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Last Month</a>
                                                <a class="dropdown-item" href="javascript:void(0)">Next Month</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div> --}}
                            </div>
                            <div class="card-body">
                                <div class="review-list">
                                    <ul class="" id="review-list">
                                        @if (isset($reviews))
                                            @forelse ($reviews as $review)
                                                <li class="review-box ">
                                                    <div class="review-profile">
                                                        <div class="review-img">
                                                            <img src="{{ asset('vendor/profile_image/avatar.jpg') }}"
                                                                class="img-fluid" alt="img">
                                                        </div>
                                                    </div>
                                                    <div class="review-details">
                                                        <h6>{{ $review->user->name }}</h6>
                                                        <div class="rating">
                                                            <div class="rating-star">

                                                                {{-- ${{reviewStar(value.rating)}} --}}

                                                            </div>
                                                            <div><i class="fa-sharp fa-solid fa-calendar-days"></i>
                                                                {{ convertMdyToTimeAgo($review->updated_at) }}</div>

                                                        </div>
                                                        <p> {{ $review->review }}</p>


                                                    </div>
                                                </li>
                                            @empty
                                                <li>No Review</li>
                                            @endforelse

                                            {{ $reviews->links('pagination::bootstrap-5') }}
                                        @endif
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
