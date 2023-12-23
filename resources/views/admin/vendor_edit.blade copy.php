@extends('admin.layout.layout')

@section('content')

    <div class="container">
        <h2>Vendor Detail</h2>

        @if(isset($vendor['avatar']))
        <div class="vendor-profile">
            <div class="vendor-avatar">
                <img src="{{ asset('vendor/vendor_image/' . $vendor['vendor']['avatar']) }}" alt="Avatar">
            </div>
            @endif
            <div class="vendor-info">
                <h3>{{ $vendor['vendor']['name'] ?? '' }}</h3>
                <img src="{{ asset('vendor/vendor_image/' . $vendor['vendor']['avatar']) }}" alt="Avatar" style="width:300px;height:300px">
                <p><strong>Username:</strong> {{ $vendor['vendor']['username']?? '' }}</p>
                <p><strong>Email:</strong> {{ $vendor['vendor']['email'] ?? ''}}</p>
                <p><strong>Mobile:</strong> {{ $vendor['vendor']['mobile']?? '' }}</p>
                <p><strong>Date of Birth:</strong> {{ $vendor['vendor']['dob'] ?? ''}}</p>
                <p><strong>Gender:</strong> {{ ucfirst($vendor['vendor']['gender']?? '') }}</p>
                {{-- <p><strong>Status:</strong> {{ $vendor['status'] === 0 ? 'Inactive' : 'Active' }}</p> --}}
                {{-- Add other vendor details as needed --}}
            </div>
        </div>

        <div class="vendor-description">
            <h3>Profile Description</h3>
            <p>{{ $vendor['profile_description']?? '' }}</p>
        </div>

        <div class="vendor-occupation">
            <h3>Occupation</h3>
            <p>{{ $vendor['occupation']['occupation_name']?? '' }}</p>
            <p><strong>Experience:</strong> {{ $vendor['experience_year']?? '0' }} years {{ $vendor['experience_month'] ?? '0'}} months</p>
        </div>

        <div class="vendor-services">
            <h3>Services</h3>
            <p>{{ $vendor['services'] ?? 'No services specified' }}</p>
        </div>

        <div class="vendor-rating">
            <h3>Rating</h3>
            <p>{{ $vendor['rating']?? '0' }} out of 5</p>
        </div>

        <div class="vendor-location">
            <h3>Location</h3>
            <p><strong>Address:</strong> {{ $vendor['address']?? '' }}</p>
            <p><strong>City:</strong> {{ $vendor['city']['name'] ?? ''}}</p>
            <p><strong>State:</strong> {{ $vendor['state']['name'] ?? ''}}</p>
            <p><strong>Country:</strong> {{ $vendor['country']['name']?? '' }}</p>
            <p><strong>Pincode:</strong> {{ $vendor['pincode'] ?? ''}}</p>
            <p><strong>Latitude:</strong> {{ $vendor['latitude']?? '' }}</p>
            <p><strong>Longitude:</strong> {{ $vendor['longitude'] ?? ''}}</p>
        </div>

        <div class="vendor-contact">
            <h3>Contact Information</h3>
            <p><strong>Email:</strong> {{ $vendor['vendor']['email'] ?? ''}}</p>
            <p><strong>Mobile:</strong> {{ $vendor['vendor']['mobile'] ?? ''}}</p>
            <p><strong>Website:</strong> <a href="{{ $vendor['website_url']?? '' }}" target="_blank">{{ $vendor['website_url'] ?? ''}}</a></p>
        </div>


    </div>
@endsection
