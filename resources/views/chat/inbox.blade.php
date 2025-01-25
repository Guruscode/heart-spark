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
                    <li class="nav-item mr-3">
                        <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
                            <i class="fa fa-inbox mr-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link d-flex align-items-center" href="{{ route('inbox') }}">
                            <i class="fas fa-inbox mr-1"></i> Inbox
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
        <div class="col-lg-9 mx-auto">
            <h1 class="mb-4">Inbox</h1>
            
            <div class="card">
                <div class="card-header">
                    <span>Messages</span>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        {{-- Loop through messages --}}
                        {{-- @foreach ($messages as $message) 
                        <a href="{{ route('messages.show', $message->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $message->sender->name }}</h5>
                                <small>{{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ Str::limit($message->content, 50) }}</p>
                            <small class="text-muted">{{ $message->is_read ? 'Read' : 'Unread' }}</small>
                        </a>
                        @endforeach --}}
                    </div>
                </div>
            </div>

            <!-- Optional: Add a button to compose a new message -->
            <div class="mt-3">
                <a href="" class="btn btn-primary">Compose New Message</a>
            </div>
        </div>
    </div>
</div>

<!-- Optional Footer -->
<footer class="mt-5 text-center text-muted">
    <small>&copy; 2024 Heart Spark. All rights reserved.</small>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@endsection
