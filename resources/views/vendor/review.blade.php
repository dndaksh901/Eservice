@extends('layouts.main')

@section('content')
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Reviews</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div>
                @include('includes.tabs')
            </div>
            <div class="row dashboard-info reviewpage-content">
                <div class="col-lg-12">
                    <div class="card dash-cards">
                        <div class="card-header">
                            <h4>Your Review (25)</h4>
                            <div class="card-dropdown">
                                <ul>
                                    <li class="nav-item dropdown has-arrow logged-item">
                                        <a href="#" class="dropdown-toggle pageviews-link"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span>All Listing</span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="javascript:void(0)">Today</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Last Week</a>
                                            <a class="dropdown-item" href="javascript:void(0)">Last Month</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="review-list">
                                <li class="review-box">
                                    <div class="review-profile">
                                        <div class="review-img">
                                            <img src="assets/img/profile-img.jpg" class="img-fluid" alt="img">
                                        </div>
                                    </div>
                                    <div class="review-details">
                                        <h6>John Doe</h6>
                                        <div class="rating">
                                            <div class="rating-star">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                            </div>
                                            <div><i class="fa-sharp fa-solid fa-calendar-days"></i> 4 months ago</div>
                                            <div>by: John Doe</div>
                                        </div>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has
                                            been the industry's standard dummy.</p>
                                        <ul class="review-gallery">
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-1.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-2.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-3.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-4.jpg">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="review-box">
                                    <div class="review-profile">
                                        <div class="review-img">
                                            <img src="assets/img/profile-img.jpg" class="img-fluid" alt="img">
                                        </div>
                                    </div>
                                    <div class="review-details">
                                        <h6>John Doe</h6>
                                        <div class="rating">
                                            <div class="rating-star">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                            </div>
                                            <div><i class="fa-sharp fa-solid fa-calendar-days"></i> 6 months ago</div>
                                            <div>by: John Doe</div>
                                        </div>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has
                                            been the industry's standard dummy.</p>
                                    </div>
                                </li>
                                <li class="review-box">
                                    <div class="review-profile">
                                        <div class="review-img">
                                            <img src="assets/img/profile-img.jpg" class="img-fluid" alt="img">
                                        </div>
                                    </div>
                                    <div class="review-details">
                                        <h6>John Doe</h6>
                                        <div class="rating">
                                            <div class="rating-star">
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                                <i class="fas fa-star filled"></i>
                                            </div>
                                            <div><i class="fa-sharp fa-solid fa-calendar-days"></i> 11 months ago</div>
                                            <div>by: John Doe</div>
                                        </div>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. It has
                                            been the industry's standard dummy.</p>
                                        <ul class="review-gallery">
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-1.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-2.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-3.jpg">
                                            </li>
                                            <li>
                                                <img class="img-fluid" alt="Image"
                                                    src="assets/img/gallery/review-4.jpg">
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
