@extends('layout.admin.master')

@section('title', 'Home Page')

@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Main content -->
    <div class="main-content">
        @include('layout.admin.nav')
        <!-- Main content area -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h1>Nurses</h1>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Customer </th>
                            <th scope="col">Nurse</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Rating</th>
                            <th scope="col">Comment</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($nurserequests as $nurse)
                            <tr>
                                <th scope="row">{{ $i++ }}</th>
                                <td><strong>{{ $nurse->user->name }}</strong></td>
                                <td><strong>{{ $nurse->nurse->name }}</strong></td>
                                <td><strong>{{ $nurse->updated_at->diffForHumans() }}</strong></td>
                                @if ($nurse->status == 'requested')
                                    <td><strong class="badge badge-primary">Requested</strong></td>
                                @elseif($nurse->status == 'accepted')
                                    <td><strong class="badge badge-info">Accepted</strong></td>
                                @elseif($nurse->status == 'completed')
                                    <td><strong class="badge badge-success">Completed</strong></td>
                                    @elseif($nurse->status == 'removed')
                                    <td><strong class="badge badge-danger">Removed</strong></td>
                                    @elseif($nurse->status == 'terminate')
                                    <td><strong class="badge badge-success ">Terminate</strong></td>
                                @else
                                    <td><strong class="badge badge-danger">Rejected</strong></td>
                                @endif
                                <td>
                                    @php
                                        $rating = $nurse->rating;
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
                                </td>
                                <td>{{ $nurse->comment }}</td>
                                <td class="d-flex">
                                    @if ($nurse->status == 'requested')
                                        <a class="btn btn-success btn-sm mx-2"
                                            href="{{ route('nurses.request.accept', $nurse->id) }}">Accept</a>
                                        <a class="btn btn-danger btn-sm mx-2"
                                            href="{{ route('nurses.request.reject', $nurse->id) }}">Reject</a>
                                    @endif
                                    @if ($nurse->status == 'accepted')
                                        <a class="btn btn-primary btn-sm mx-2"
                                            href="{{ route('nurses.request.complete', $nurse->id) }}">Complete</a>
                                    @endif
                                  
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
