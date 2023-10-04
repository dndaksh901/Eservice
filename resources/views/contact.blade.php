@extends('layouts.main')

@section('content')
<style>
    a{
        color:white;
    }
</style>
    <div class="contactbanner innerbanner">
        <div class="inner-breadcrumb">
            <div class="container">
                <div class="row align-items-center text-center">
                    <div class="col-md-12 col-12 ">
                        <h2 class="breadcrumb-title">Contact Us</h2>
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="contactus-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 contactus-img col-md-12">
                    <div class="contactleft-info">
                        <img src="assets/img/contactleftimg.jpg" class="img-fluid" alt="">
                        <div class="contactinfo-content">
                            <div class="contact-hours">
                                <h6>Hours</h6>
                                <ul>
                                    <li>Sunday - Saturday : 24/7 Support Available</li>

                                </ul>
                            </div>
                            <div class="contact-hours">
                                <h6>Contact Us</h6>
                                <ul>
                                    <li>BIX 449/153, New Santokhpura, Jalandhar, Punjab, India 144004</li>
                                    {{-- <li>Tel : <a href="tel:+917696396740">+91 7696396740</a></li> --}}
                                    <li> Email : <a href="mail:aksh901@gmail.com"
                                            class="__cf_email__"
                                            data-cfemail="4a393f3a3a25383e0a2623393e2f2f64292527">aksh901@gmail.com</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 contactright-map col-md-12">
                    <div class="google-maps">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3407.41207208262!2d75.59224907451652!3d31.34760615565928!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5bad3d40fd25%3A0x362552ac25ef2732!2sEnovant%20World!5e0!3m2!1sen!2sin!4v1693235617200!5m2!1sen!2sin"
                            width="600" height="544" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section class="contactusform-section">
        <div class="container">
            <div class="contact-info">
                <h2>Contact <span>Us</span></h2>
                <p>We are here to help you</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-5">
                    <div class="contactform-img">
                        <img src="assets/img/contactform-img.svg" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="contactus-form">
                        <!-- Success message -->
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        <form method="post" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'error' : '' }}"
                                    placeholder="Name*" name="name" id="name">
                                <!-- Error -->
                                @if ($errors->has('name'))
                                    <div class="error">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group me-0">
                                <input type="email" class="form-control {{ $errors->has('email') ? 'error' : '' }}"
                                    placeholder="Email*" name="email" id="email">
                                @if ($errors->has('email'))
                                    <div class="error">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control {{ $errors->has('subject') ? 'error' : '' }}"
                                    placeholder="Subject" name="subject" id="subject">
                                @if ($errors->has('subject'))
                                    <div class="error">
                                        {{ $errors->first('subject') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <textarea rows="4" class="form-control {{ $errors->has('message') ? 'error' : '' }}"
                                    placeholder="Write a Message*" name="message" id="message"></textarea>
                                @if ($errors->has('message'))
                                    <div class="error">
                                        {{ $errors->first('message') }}
                                    </div>
                                @endif
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn" type="submit" name="send" value="Submit">
                                    Submit </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
