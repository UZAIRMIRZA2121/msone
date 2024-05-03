@extends('layout.frontend.master')

@section('title', 'Home Page')

@section('content')
    <main>
        <main>
            <section class="fleet-hero hero-section">
                <h1 class="hero-head fleet-head">Our Featured Services</h1>
                <p class="hero-para">A porfolio of our services <br> at your doorstep.</p>
                <div class="fleet-btn-div">
                    <a href="#" class="fleet-btn ">See Featured Categories</a>
                </div>

            </section>
            <section class="container py-5">
                <div class="row ">
                    <div class="row pt-5">
                        <h1 class="py-5">Featured <b>Nurses</b></h1>
                        <div class="row ">
                            @if ($nurses)
                                @foreach ($nurses as $nurse)
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 ">
                                        <a href="{{ route('nurse', ['nurse' => $nurse->id]) }}" class="thumb-wrapper-link">
                                            <div class="thumb-wrapper">
                                                {{-- <span class="sale-label " style="top:80px;">Sale 20%</span> --}}
                                                <div class="img-box">
                                                    <img src="{{ asset($nurse->img) }}" class="img-fluid" alt="Apple iPad">
                                                </div>
                                                <div class="thumb-content">
                                                    <h4>{{ $nurse->name }}</h4>

                                                    <div class="star-rating">
                                                        <ul class="list-inline">
                                                            @php
                                                                $nurseTotalRating = 0; // Initialize total rating
                                                                $totalRatingsCount = 0; // Initialize total ratings count

                                                                // Loop through each nurse hire record
                                                                foreach ($nurse->nurseHires as $hire) {
                                                                    // Check if the status is completed
                                                                    if ($hire->status === 'terminate') {
                                                                        // Add the rating to the total rating
                                                                        $nurseTotalRating += $hire->rating;

                                                                        // Increment total ratings count
                                                                        $totalRatingsCount++;
                                                                    }
                                                                }

                                                                // Calculate average rating
                                                                $averageRating =
                                                                    $totalRatingsCount > 0
                                                                        ? $nurseTotalRating / $totalRatingsCount
                                                                        : 0;

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
                                                    <p class="item-price"><b>Rs : {{ $nurse->hourly_rate }}/Hour</b></p>
                                                    <a href="{{ route('nurse', ['nurse' => $nurse->id]) }}"
                                                        class="btn btn-sm">Details</a>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <h1>There are not product in this category</h1>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

        </main>
    @endsection
