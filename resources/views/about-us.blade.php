@extends('layouts.main')

@section('content')
<style>
#about-title {
    background-color: #c10037;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    margin-bottom:20px;
}

/* .container {
    width: 80%;
    margin: auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
} */

h1 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #fff;
}

h2 {
    font-size: 20px;
    color: #fff;
}

p {
    font-size: 16px;
    line-height: 1.6;
}

ul {
    list-style: disc;
    margin-left: 20px;
}

a {
    color: #007BFF;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}
</style>
<main>
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">About US</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                About us
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
<div id="about-title">
    <h1>Welcome to {{ env('APP_NAME') }}</h1>
    <p>Your trusted source for connecting with a diverse and skilled workforce.</p>
</div>

<div class="container">
    <h2>Our Mission</h2>
    <p>
        At {{ env('APP_NAME') }}, our mission is to empower you by simplifying the process of finding and hiring skilled and expert workers.
        We're committed to ensuring that your projects, repairs, and services are handled by the best in the business.
        Our platform brings together a community of professionals who share our vision of excellence.
    </p>

    <h2>What Makes Us Unique</h2>
    <ul>
        <li><strong>Diverse Expertise:</strong> We take pride in offering a wide range of services to meet your unique needs. From home improvement to personal services, we have skilled professionals across various industries.</li>
        <li><strong>Quality Assurance:</strong> We understand the importance of quality work. Every professional on our platform is thoroughly vetted, ensuring that they meet our high standards.</li>
        <li><strong>Easy Access:</strong> We've designed our platform for your convenience. Finding, hiring, and communicating with skilled workers is just a few clicks away.</li>
        <li><strong>Safety and Trust:</strong> Your safety is our priority. Our rigorous screening process and background checks provide you with peace of mind.</li>
        <li><strong>Transparent Pricing:</strong> We believe in transparent pricing. With us, you'll receive detailed estimates and know what to expect before the work begins.</li>
        <li><strong>Customer Support:</strong> Our friendly customer support team is always available to assist you. We're here to answer your questions and address any concerns.</li>
    </ul>

    <h2>Meet Our Skilled Workers</h2>
    <ul>
        <li><strong>Plumbers:</strong> Experts in fixing leaks, unclogging drains, and maintaining your plumbing systems.</li>
        <li><strong>Carpenters:</strong> Craftsmen who can handle everything from furniture repair to home renovation projects.</li>
        <li><strong>Electricians:</strong> Licensed professionals ensuring the safety and reliability of your electrical systems.</li>
        <li><strong>Interior Designers:</strong> Creative minds ready to transform your living spaces into works of art.</li>
        <li><strong>Mechanics:</strong> Skilled technicians who keep your vehicles running smoothly.</li>
        <li><strong>Tutors:</strong> Educators dedicated to helping you achieve academic success.</li>
        <li><strong>Drivers:</strong> Dependable chauffeurs for your transportation needs.</li>
        <li><strong>And More:</strong> Explore our platform for a wide range of services tailored to your specific requirements.</li>
    </ul>

    <h2>Join Our Community</h2>
    <p>Join the community of satisfied customers who have experienced the convenience of finding skilled workers for various jobs. Your satisfaction is our ultimate goal. We're here to connect you with the right professionals for your projects, repairs, and services.</p>
<div class="mb-5">
    <p><a href="{{ url('register') }}">Register</a> | <a href="{{ url('contact-us') }}">Contact Us</a></p>
</div>
</div>
</main>
@endsection
