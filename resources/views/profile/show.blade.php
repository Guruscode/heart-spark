@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand font-weight-bold" href="{{ route('index.home') }}">Heart Spark</a>
            
            <!-- Toggler button for mobile view -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <!-- Navbar content -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <!-- Centered Search Bar -->
                <form class="form-inline mx-auto d-none d-lg-block w-50">
                    <input class="form-control w-100" type="search" placeholder="Search profiles..." aria-label="Search">
                </form>
    
                <!-- Right section (Inbox, View Profile, Upgrade Button, Logout Button) -->
                <ul class="navbar-nav ml-auto align-items-center">
                   <!-- Inbox Icon -->
                   <li class="nav-item mr-3">
                    <a class="nav-link d-flex align-items-center" href="{{route('home')}}">
                        <i class="fas fa-inbox mr-1"></i> Home
                    </a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link d-flex align-items-center" href="{{ route('inbox') }}">
                        <i class="fa fa-inbox mr-1"></i> Inbox
                    </a>
                </li>

                   <!-- View Profile -->
                   <li class="nav-item dropdown mr-3">
                       <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <img src="{{ asset('assets/img/small-team/st1.jpg') }}" class="rounded-circle" alt="User Avatar" style="width: 30px; height: 30px; object-fit: cover;"> <!-- Smaller Avatar -->
                           <span class="ml-2" style="font-size: 14px;">{{ Auth::user()->name }}</span> <!-- Show authenticated user's name -->
                       </a>
                       <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                           <a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a>
                       </div>
                   </li>
                    
                   <!-- Logout Button -->
                   <li class="nav-item m-2">
                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
                           @csrf
                           <button type="submit" class="nav-link btn btn-info text-black px-4" onclick="event.preventDefault(); this.closest('form').submit();">
                               Logout
                           </button>
                       </form>
                   </li>
                   <!-- Upgrade Button -->
                   <li class="nav-item">
                       <a class="nav-link btn btn-primary text-white px-4" href="#">
                           Upgrade Account
                       </a>
                   </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container my-5" style="margin-top: 80px;"> <!-- Added margin-top to prevent overlap with the navbar -->
        <h1 class="mb-4">My Profile</h1>
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>User Profile</span>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="{{ asset($user->profile_picture ?? 'assets/img/default-avatar.jpg') }}" class="rounded-circle mb-3" alt="User Avatar" style="width: 150px; height: 150px; object-fit: cover;"> <!-- User Avatar -->
                        <h5 class="card-title">{{ $user->name }}</h5>
                    </div>
                    <div class="col-md-8">
                        <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="card-text"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                        <p class="card-text"><strong>Age:</strong> {{ $user->age ?? 'N/A' }}</p> <!-- Add age if available -->
                        <p class="card-text"><strong>Gender:</strong> {{ ucfirst($user->gender ?? 'N/A') }}</p> <!-- Add gender if available -->
                        <p class="card-text"><strong>Location:</strong> {{ $user->location ?? 'N/A' }}</p> <!-- Add location if available -->
                        <p class="card-text"><strong>Bio:</strong> {{ $user->bio ?? 'N/A' }}</p> <!-- Add bio if available -->
                        <p class="card-text"><strong>Interests:</strong> 
                            @if ($user->interests)
                                @php
                                    $interestsArray = json_decode($user->interests, true);
                                @endphp
                                {{ is_array($interestsArray) ? implode(', ', $interestsArray) : 'N/A' }}
                            @else
                                N/A
                            @endif
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional sections for user activity or connections could be added here -->
        <div class="my-4">
            <h4>Recent Activity</h4>
            <ul class="list-group">
                <li class="list-group-item">You liked a profile.</li>
                <li class="list-group-item">You matched with User X.</li>
                <li class="list-group-item">User Y sent you a message.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Optional Footer -->
<footer class="mt-5 text-center text-muted">
    <small>&copy; 2024 Matchify. All rights reserved.</small>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@endsection
