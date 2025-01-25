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
    <div class="row mt-5 pt-4">
        <!-- Sidebar (Contacts and Notifications) -->
        <div class="col-lg-3 d-none d-lg-block">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    Recent Users
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($recentUsers as $user)
                        <li class="list-group-item d-flex align-items-center">
                            <img 
                                src="{{ asset('storage/' . $user->profile_picture) ?? 'https://via.placeholder.com/40' }}" 
                                alt="{{ $user->name ?? 'Unnamed User' }}" 
                                class="rounded-circle me-3" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                            <span>{{ $user->name ?? 'Unnamed User' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No recent users found.</li>
                    @endforelse
                </ul>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    Matches
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($matches as $match)
                        <li class="list-group-item d-flex align-items-center">
                            <img 
                                src="{{ asset('storage/' . $user->profile_picture)  ?? 'https://via.placeholder.com/40' }}" 
                                alt="{{ $user->name ?? 'Unnamed User' }}" 
                                class="rounded-circle me-3" 
                                style="width: 40px; height: 40px; object-fit: cover;">
                            <span>{{ $user->name ?? 'Unnamed User' }}</span>
                        </li>
                    @empty
                        <li class="list-group-item">No matches found.</li>
                    @endforelse
                </ul>
            </div>
            
        </div>

        <!-- Profile Cards Section -->
        <div class="col-lg-9">
            <div class="row">
                @foreach($users as $user) <!-- Loop to display each user -->
                <div class="col-md-4 col-lg-3 col-sm-6 mb-4">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="card-text">Age: {{ $user->age }} | Location: {{ $user->location }}</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-primary like-button" data-user-id="{{ $user->id }}">Like</button>
                                <button type="button" class="btn btn-secondary">Message</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Optional Footer -->
<footer class="mt-5 text-center text-muted">
    <small>&copy; 2025 Heart Spark. All rights reserved.</small>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
 document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const likedUserId = this.getAttribute('data-user-id');

            fetch('/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ liked_user_id: likedUserId }),
            })
                .then(response => {
                    // Check if the response is not OK
                    if (!response.ok) {
                        console.error('Response Error:', {
                            status: response.status,
                            statusText: response.statusText,
                            url: response.url,
                        });

                        // Attempt to parse response text for debugging
                        return response.text().then(errorText => {
                            console.error('Error Response Text:', errorText);
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message);

                        if (data.liked_limit_exceeded) {
                            toastr.warning(
                                'You have reached your like limit! Upgrade your account to like more users.',
                                'Upgrade Required'
                            );
                        }
                    } else {
                        console.warn('Operation Warning:', {
                            message: data.message || 'An unknown issue occurred.',
                            responseData: data,
                        });
                        toastr.error(data.message || 'An error occurred. Please try again.');
                    }
                })
                .catch(error => {
                console.error('Fetch Error Details:', {
                    message: error.message,
                    stack: error.stack,
                });
                toastr.error('An unexpected error occurred. Please check your network connection.');
            });

        });
    });
});

</script>
  
@endsection
