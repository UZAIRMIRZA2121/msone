@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <section class="fleet-hero hero-section boat-section">
            <h1 class="hero-head fleet-head">Nurse Review</h1>
        </section>
        <center>
            @if (session('success'))
                <div id="Message" class="alert alert-success container w-50" style="margin-top: 40px;
font-size: 22px;">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div id="Message" class="alert alert-danger container w-50" style="margin-top: 40px;
font-size: 22px;">
                    {{ session('error') }}
                </div>
            @endif
        </center>

        <div class="container">
            <section class="nurse-grid">
                <img src="{{ asset($nurse->img) }}" alt="">
                <div class="nurse-flex">
                    <h3>Name : {{ $nurse->name }}</h3>
                    <h2>Rs : {{ $nurse->hourly_rate }}/Hour</h2>
                    <h5>Qualification : {{ $nurse->qualification }}</h5>
                    <h5>Email : {{ $nurse->email }}</h5>
                    <h5>Address : {{ $nurse->address }}</h5>
                    <h5>Age: {{ \Carbon\Carbon::parse($nurse->date_of_birth)->age }} Years</h5>
                    <h5>Experience : {{ $nurse->experience_years }} Year</h5>
                    <h5>Specialization : {{ $nurse->specialization }}</h5>

                    <div class="star-rating">
                        <ul class="list-inline">
                            @php
                                $nurseTotalRating = 0; // Initialize total rating
                                $totalRatingsCount = 0; // Initialize total ratings count

                                // Loop through each nurse hire record
                                foreach ($nurse->nurseHires as $hire) {
                                    // Check if the status is "terminated"
                                    if ($hire->status === 'terminate') {
                                        // Add the rating to the total rating
                                        $nurseTotalRating += $hire->rating;

                                        // Increment total ratings count
                                        $totalRatingsCount++;
                                    }
                                }

                                // Calculate average rating
                                $averageRating = $totalRatingsCount > 0 ? $nurseTotalRating / $totalRatingsCount : 0;

                                // Output star ratings based on the average rating
                                $maxRating = 5; // Maximum rating
                                $wholeStars = floor($averageRating); // Whole star count
                                $fractionalStar = $averageRating - $wholeStars; // Fractional part of the rating

                                // Output whole stars
                                for ($i = 0; $i < $wholeStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }

                                // Output fractional star if exists
                                if ($fractionalStar > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                    $wholeStars++; // Increment whole star count
                                }

                                // Output remaining empty stars
                                for ($i = $wholeStars; $i < $maxRating; $i++) {
                                    echo '<i class="far fa-star"></i>';
                                }
                            @endphp
                        </ul>
                    </div>
                    <a href="{{ route('nurse.hire', ['id' => $nurse->id]) }}" class="obj-mbtn">Hire</a>

                </div>

            </section>
            <section class="description-section pt-5">
                <h1>Description</h1>
                @if ($nurse->desc)
                    <p>{{ $nurse->desc }}</p>
                @else
                    <p>Description not available</p>
                @endif
            </section>
            
        </div>
        <section class="review py-5">
            <h1 class="pt-5">Reviews</h1>
        
            @php
                $reviewExists = false;
            @endphp
        
            @foreach ($nurse->nurseHires as $hire)
                @if ($hire->status === 'terminate')
                    @php
                        $reviewExists = true;
                    @endphp
        
                    <div>
                        <p>{{ $hire->comment }}</p>
        
                        <span>
                            @php
                                $rating = $hire->rating;
                                $maxRating = 5; // Maximum rating
                                $wholeStars = floor($rating); // Whole star count
                                $fractionalStar = $rating - $wholeStars; // Fractional part of the rating
        
                                // Output whole stars
                                for ($i = 0; $i < $wholeStars; $i++) {
                                    echo '<i class="fas fa-star"></i>';
                                }
        
                                // Output fractional star if exists
                                if ($fractionalStar > 0) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                    $wholeStars++; // Increment whole star count
                                }
        
                                // Output remaining empty stars
                                for ($i = $wholeStars; $i < $maxRating; $i++) {
                                    echo '<i class="far fa-star  "></i>';
                                }
        
                            @endphp
                        </span>
                    </div>
                @endif
            @endforeach
        
            @if (!$reviewExists)
            <div><p>Not yet reviewed</p></div>
                
            @endif
        </section>
        

    </main>
@endsection
