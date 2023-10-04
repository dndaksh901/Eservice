@extends('layouts.main')

@section('content')
    <style>
        .progress {
            --bs-progress-height: 0.7rem;
        }

        .progress-bar {
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            color: var(--bs-progress-bar-color);
            text-align: center;
            white-space: nowrap;
            background-color: #ffa800;
            transition: var(--bs-progress-bar-transition);
        }

        div#address i.addess-icon,
        a.website:hover {
            color: #c10037;
        }

        div#address i:hover {
            color: #ffffff;
        }

        .social-buttons {
            border-radius: 5px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            margin-top: 0;
        }

        .social-buttons__button {
            margin: 1px;
        }

        .social-button {
            border-radius: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            outline: none;
            width: 2.5rem;
            height: 2.5rem;
            text-decoration: none;
        }

        .social-icons {
            width: 100%;
        }

        .social-button__inner {
            font-size: 2.3rem;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: calc(100% - 2px);
            height: calc(100% - 2px);
            border-radius: 100%;
            background: #fff;
            text-align: center;
        }

        .social-button i,
        .social-button svg {
            position: relative;
            z-index: 1;
            transition: 0.3s;
        }

        .social-button i {
            font-size: 20px;
        }

        .social-button svg {
            height: 40%;
            width: 40%;
        }

        .social-button::after {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            display: block;
            width: 0;
            height: 0;
            border-radius: 100%;
            transition: 0.3s;
        }

        .social-button:focus,
        .social-button:hover {
            color: #fff;
            text-decoration: none;
        }

        .social-button:focus::after,
        .social-button:hover::after {
            width: 100%;
            height: 100%;
            margin-left: -50%;
        }

        .social-button--facebook {
            color: #3b5999;
        }

        .social-button--facebook::after {
            background: #3b5999;
        }

        .social-button--twitter {
            color: #55acee;
        }

        .social-button--twitter::after {
            background: #55acee;
        }

        .social-button--youtube {
            color: #bb0000;
        }

        .social-button--youtube::after {
            background: #bb0000;
        }

        .social-button--instagram {
            color: #e4405f;
        }

        .social-button--instagram::after {
            background: #e4405f;
        }

        /* social media icons end  */

        /* Review and star rating */
        .review-list li:nth-child(2) {
            margin-left: 0;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

        .star-rating-complete {
            color: #c59b08;
        }

        .rating-container .form-control:hover,
        .rating-container .form-control:focus {
            background: #fff;
            border: 1px solid #ced4da;
        }

        .rating-container textarea:focus,
        .rating-container input:focus {
            color: #000;
        }

        .rated {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rated:not(:checked)>input {
            position: absolute;
            display: none;
        }

        .rated:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ffc700;
        }

        .rated:not(:checked)>label:before {
            content: '★ ';
        }

        .rated>input:checked~label {
            color: #ffc700;
        }

        .rated:not(:checked)>label:hover,
        .rated:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rated>input:checked+label:hover,
        .rated>input:checked+label:hover~label,
        .rated>input:checked~label:hover,
        .rated>input:checked~label:hover~label,
        .rated>label:hover~input:checked~label {
            color: #c59b08;
        }

        .callnow {
            width: max-content;
        }

        .fa-message {
            color: #fff;
        }

        .callnow button {
            position: relative;
            top: -16px;
            padding: 14px 58px;
        }


        .callnow button:hover>i.fa-message {
            color: #c10037;
        }

        .message-modal {
            top: 10rem;
        }

        button.close {
            background: transparent;
            border: 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            color: #000;
            text-shadow: 0 1px 0 #fff;
            opacity: .5;

        }

        /* Review and star rating end */
    </style>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">Vendor Profile</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Profile
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section class="details-description">
        <div class="container">
            <div class="about-details">
                <div class="about-headings">
                    <div class="author-img">
                        <img src="{{ asset('vendor/vendor_image/' . $profile->vendor->avatar ?? 'avatar.jpg') }}"
                            alt="vendor">
                    </div>
                    <div class="authordetails">
                        <h5>{{ $profile->vendor->name ?? $profile->vendor->username }}</h5>
                        <p><strong>({{ $profile->occupation->occupation_name }})</strong></p>
                        <p>{{ $profile->experience_year }} Years, {{ $profile->experience_month }} Months</p>
                        <div class="rating">
                            @for ($rating = 1; $rating <= round($profile->rating); $rating++)
                                <i class="fas fa-star filled"></i>
                            @endfor

                            {{-- <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fas fa-star filled"></i>
                            <i class="fa-regular fa-star rating-color"></i> --}}
                            {{-- <span class="d-inline-block average-rating"> {{ round ($profile->rating) }} </span> --}}
                        </div>
                    </div>
                </div>
                <div class="rate-details">
                    @if ($profile->price_per_hour)
                        <h2> &#8377; {{ $profile->price_per_hour }}</h2>
                        <p>Per Hour or Visit Charges</p>
                    @endif
                </div>

            </div>
            <div class="descriptionlinks">
                <div class="row">
                    <div class="col-lg-8">
                        <ul>
                            <li><a href="#address"><i class="feather-map"></i> Get Address</a></li>
                            <li><a href="#description"><i class="feather-zap"></i> Description</a></li>
                            <li><a href="#services"><i class="feather-package"></i>Our services</a></li>
                            <li><a href="#gallery"><i class="feather-image"></i>Gallery</a></li>
                            <li><a href="#review-section"><i class="fa-regular fa-comment-dots"></i> Write a review</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <div class="callnow">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModal"><i class="fa-regular fa-message"></i> Message</button>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="callnow">
                            <a href="tel:{{ $profile->vendor->mobile }}"> <i class="feather-phone-call"></i> Call Now</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>



    <div class="details-main-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!---- Address Detail ---->
                    <div class="card" id="address">
                        <div class="card-header">
                            <i class="feather-zap"></i>
                            <h4>Address</h4>
                        </div>
                        <div class="map-details">
                            {{-- <div class="map-frame">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.138528387797!2d-122.41637708468208!3d37.78479337975754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858090475dcdc3%3A0x417fdbbd16e076ed!2s484%20Ellis%20St%2C%20San%20Francisco%2C%20CA%2094102%2C%20USA!5e0!3m2!1sen!2sin!4v1669879954211!5m2!1sen!2sin"
                                    width="200" height="160" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div> --}}
                            <div class="row">
                                <div class="col-12 mt-2 mb-2">
                                    <p><i class="feather-map-pin addess-icon"></i> {!! !empty($profile->address) ? $profile->address . ',' : '' !!}
                                        {!! !empty($profile->city) ? $profile->city->name . ', ' : '' !!}{!! !empty($profile->state) ? $profile->state->name . ', ' : '' !!}{!! !empty($profile->country) ? $profile->country->name . ', ' : '' !!}{!! !empty($profile->pincode) ? $profile->pincode : '' !!}
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <i class="feather-phone-call addess-icon"></i> <a
                                        href="tel:{{ !empty($profile->vendor) ? $profile->vendor->mobile : '' }}">
                                        {{ !empty($profile->vendor) ? $profile->vendor->mobile : '' }}</a>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <i class="feather-mail addess-icon"></i> <a
                                        href="mailto:{{ !empty($profile->vendor) ? $profile->vendor->email : '' }}"
                                        class="__cf_email__">{{ !empty($profile->vendor) ? $profile->vendor->email : '' }}</a>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    @if (isset($profile->website_url))
                                        <img src="{{ asset('assets/img/website.svg') }}" alt="website"> <a
                                            href="{{ $profile->website_url }}" target="_blank"
                                            class="website">{{ $profile->website_url }}</a>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-12 mb-2">
                                    <div class="social-buttons">
                                        <i class="feather-social addess-icon"></i>
                                        @if (isset($profile->vendor->facebook))
                                            <a href="{!! $profile->vendor->facebook !!}"
                                                class="social-buttons__button social-button social-button--facebook"
                                                aria-label="Facebook">
                                                <span class="social-button__inner">
                                                    <i class="fab fa-facebook-f"></i>
                                                </span>
                                            </a>
                                        @endif

                                        @if (isset($profile->vendor->instagram))
                                            <a href="{{ $profile->vendor->instagram }}" target="_blank"
                                                class="social-buttons__button social-button social-button--instagram"
                                                aria-label="InstaGram">
                                                <span class="social-button__inner">
                                                    <i class="fab fa-instagram"></i>
                                                </span>
                                            </a>
                                        @endif

                                        @if (isset($profile->vendor->twitter))
                                            <a href="{{ $profile->vendor->twitter }}" target="_blank"
                                                class="social-buttons__button social-button social-button--twitter"
                                                aria-label="twitter">
                                                <span class="social-button__inner">
                                                    <i class="fab fa-twitter"></i>
                                                </span>
                                            </a>
                                        @endif

                                        @if (isset($profile->vendor->youtube))
                                            <a href="{{ $profile->vendor->youtube }}" target="_blank"
                                                class="social-buttons__button social-button social-button--youtube"
                                                aria-label="youtube">
                                                <span class="social-button__inner">
                                                    <i class="fab fa-youtube"></i>
                                                </span>
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!---- Address Detail end ---->

                    <!---- Profile Description---->
                    @if (!empty($profile->profile_description))
                        <div class="card" id="description">
                            <div class="card-header">
                                <span class="bar-icon">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </span>
                                <h4>Description</h4>
                            </div>
                            <div class="card-body">
                                <p>{{ $profile->profile_description }}
                                </p>

                            </div>
                        </div>
                    @endif
                    <div class="card" id="services">
                        <div class="card-header">
                            <i class="feather-list"></i>
                            <h4>Discover Our Services</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $services = explode(',', $profile->services);
                                @endphp
                                @if (isset($services))
                                    @foreach ($services as $service)
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="featues-info">
                                                <h6><i class="fab fa-unity"></i> {{ ucfirst($service) }}</h6>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>

                    <!---- Profile Description end ---->

                    <!---- Profile images ---->
                    <div class="card gallery-section" id="gallery">
                        <div class="card-header">
                            <i class="feather-image"></i>
                            <h4>Gallery</h4>
                        </div>
                        <div class="card-body">
                            <div class="gallery-content">
                                <div class="row">
                                    @if (isset($profile->profileImage))
                                        @foreach ($profile->profileImage as $key => $image)
                                            <div class="col-lg-3 col-md-3 col-sm-3">
                                                <div class="gallery-widget">
                                                    <a href="{{ asset('vendor/profile_image/') . '/' . $image->profile_image }}"
                                                        data-fancybox="gallery-{{ $key }}" target="_black">
                                                        <img class="img-fluid" alt="Image"
                                                            src="{{ asset('vendor/profile_image/') . '/' . $image->profile_image }}">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                      <div id="reviews-list"></div>
                    <div class="card review-sec  mb-0">
                        <div class="card-header  align-items-center">
                            <i class="fa-regular fa-comment-dots"></i>
                            <h4>Write a Review</h4>
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
                                                    {{-- <h6>{{ $review->user->name }}</h6> --}}
                                                    <div class="rating">
                                                        <div class="rating-star">

                                                            {{-- //${reviewStar(value.rating)} --}}

                                                        </div>
                                                        <div><h6>{{ $review->user->name }}</h6> <span class="text-center"><i class="fa-sharp fa-solid fa-calendar-days"></i>
                                                             {{ convertMdyToTimeAgo($review->updated_at) }}</span></div>

                                                    </div>
                                                    <p> {{ $review->review }}</p>


                                                </div>
                                            </li>
                                            <hr>
                                        @empty
                                            <li>No Review</li>
                                        @endforelse

                                        {{ $reviews->links('pagination::bootstrap-5') }}
                                    @endif
                                </ul>
                                <ul>
                                    <li class="review-box feedbackbox mb-0" id="review-section">
                                        <div class="review-details">
                                            @if (isset($userReview))
                                                <h6>Edit your feedback about this</h6>
                                            @else
                                                <h6>Leave feedback about this</h6>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <form id="review-form">
                                                <div class="alert alert-danger print-error-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <div class="alert alert-success print-success-msg" style="display:none">
                                                    <ul></ul>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" class="form-control" id="profile_id"
                                                        placeholder="Title" value="{{ $profile->id }}">
                                                    <input type="hidden" class="form-control" name="vendor_id"
                                                        id="vendor_id" placeholder="Title"
                                                        value="{{ $profile->vendor_id }}">
                                                </div>

                                                <div class="form-group">
                                                    <textarea rows="4" class="form-control" placeholder="Write a Review*" name="review" id="review">{{ $userReview->review ?? 'null' }}</textarea>
                                                </div>
                                                <div class="reviewbox-rating">
                                                    <p><span> Rating</span>

                                                    <div class="col">
                                                        <div class="rate">
                                                            <input type="radio" id="star5" class="rate"
                                                                name="rating" value="5"
                                                                {{ !empty($userReview->rating) && $userReview->rating == 5 ? 'checked' : '' }} />
                                                            <label for="star5" title="text">5 stars</label>
                                                            <input type="radio" id="star4" class="rate"
                                                                name="rating" value="4"
                                                                {{ !empty($userReview->rating) && $userReview->rating == 4 ? 'checked' : '' }} />
                                                            <label for="star4" title="text">4 stars</label>
                                                            <input type="radio" id="star3" class="rate"
                                                                name="rating" value="3"
                                                                {{ !empty($userReview->rating) && $userReview->rating == 3 ? 'checked' : '' }} />
                                                            <label for="star3" title="text">3 stars</label>
                                                            <input type="radio" id="star2" class="rate"
                                                                name="rating" value="2"
                                                                {{ !empty($userReview->rating) && $userReview->rating == 2 ? 'checked' : '' }}>
                                                            <label for="star2" title="text">2 stars</label>
                                                            <input type="radio" id="star1" class="rate"
                                                                name="rating" value="1"
                                                                {{ !empty($userReview->rating) && $userReview->rating == 1 ? 'checked' : '' }} />
                                                            <label for="star1" title="text">1 star</label>
                                                        </div>
                                                        </p>
                                                    </div>
                                                    <div class="submit-section">
                                                        <button class="btn btn-primary submit-btn" type="submit"> Submit
                                                            Review</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!---- Reviews and comment section---->
                </div>

                <!-----Message Model ------>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog message-modal" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Quick Message</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="alert alert-danger print-error-msg-modal" style="display:none">
                                <ul></ul>
                            </div>
                            <form id="message-form">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="vendor_id" value="{{ $profile->id }}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">Name*:</label>
                                        <input type="text" class="form-control" id="notification-name"
                                            name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="notification-phone" class="col-form-label">Contact Number*:</label>
                                        <input type="text" class="form-control" id="notification-phone"
                                            name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="notification-budget" class="col-form-label">Budget:</label>
                                        <input type="text" class="form-control" id="notification-budget"
                                            name="budget">
                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Message:</label>
                                        <textarea class="form-control" id="message-text" name="message"></textarea>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary btn-modal-submit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-----Message Model end ------>

            </div>
        </div>
    </div>

    <!-- Review form end -->
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        // Review script

        function reviewStar(number) {
            var stars = '';
            for (let rating = 0; rating <= number; rating++) {
                stars += `<i class="fas fa-star filled"></i>`;
            }
            return stars;
        }

        $(function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $(".submit-btn").click(function(e) {

                e.preventDefault();
                $(".print-error-msg").css('display', 'none');
                $(".print-success-msg").css('display', 'none');
                var review = $("#review").val();
                var rating = $('input[name="rating"]:checked').val();
                var profile_id = $("#profile_id").val();
                var vendor_id = $("#vendor_id").val();

                $.ajax({
                    url: "{{ url('create-review') }}",
                    type: 'POST',
                    data: {
                        review: review,
                        rating: rating,
                        profile_id: profile_id,
                        vendor_id: vendor_id
                    },
                    success: function(data) {

                        if ($.isEmptyObject(data.error)) {
                            $("#review-form")[0].reset();
                            swal({
                                title: "Good job",
                                text: "Thank you for your Review and Rating!",
                                type: "success"
                            }).then(
                                function() {
                                    location.reload();
                                });


                        } else {

                            printErrorMsg(data.error);
                        }
                    }
                });

            });


            $(".btn-modal-submit").click(function(e) {
                e.preventDefault();

                var _token = $("input[name='_token']").val();
                var name = $("input[name='name']").val();
                var phone = $("input[name='phone']").val();
                var budget = $("input[name='budget']").val();
                var message = $("textarea[name='message']").val();
                var user_id = $("input[name='user_id']").val();
                var vendor_id = $("input[name='vendor_id']").val();

                $.ajax({
                    url: "{{ route('notification.store') }}",
                    type: 'POST',
                    data: {
                        _token: _token,
                        name: name,
                        phone: phone,
                        message: message,
                        budget,
                        user_id :user_id,
                        vendor_id :vendor_id
                    },
                    success: function(data) {

                        if ($.isEmptyObject(data.error)) {
                            $("#message-form")[0].reset();
                            swal({
                                title: "Sent",
                                text: "Your message sent Successfully",
                                type: "success"
                            }).then(
                                function() {
                                    location.reload();
                                });

                        } else {
                            printErrorMsgModal(data.error);
                        }
                    }
                });

            });

            function printErrorMsgModal(msg) {
                $(".print-error-msg-modal").find("ul").html('');
                $(".print-error-msg-modal").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg-modal").find("ul").append('<li>' + value + '</li>');
                });
            }


            function printErrorMsg(msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display', 'block');
                $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                });
            }

        });
    </script>
@endpush
