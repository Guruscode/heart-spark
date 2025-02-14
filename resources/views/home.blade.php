@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold text-primary" href="{{ route('index.home') }}">❤️ HeartSpark</a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <!-- Search Bar (Desktop View) -->
                <form class="form-inline mx-auto d-none d-lg-block w-50">
                    <input class="form-control w-100 shadow-sm" type="search" placeholder="🔍 Search profiles..." aria-label="Search">
                </form>

                <!-- Right Section -->
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="{{route('home')}}">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="{{ route('inbox') }}">
                            <i class="fas fa-envelope"></i> Inbox
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown">
                            <img src="{{ asset('assets/img/small-team/st1.jpg') }}" class="rounded-circle border" style="width: 30px; height: 30px; object-fit: cover;">
                            <span class="ml-2">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                        </form>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-sm btn-primary text-white px-4" href="#">Upgrade</a>
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

      
        <div class="col-lg-9">
            <div class="row">
                @foreach($users as $user)
                @php
                    $status = rand(0, 1) ? 'Online' : 'Away'; 
                    $badgeClass = $status === 'Online' ? 'badge-success' : 'badge-warning';
                @endphp
                <div class="col-md-4 col-lg-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="position-relative">
                            <img class="card-img-top rounded-top" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                            <span class="badge {{ $badgeClass }} position-absolute" style="top: 10px; left: 10px;">{{ $status }}</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="text-muted">Age: {{ $user->age }} | {{ $user->location }} | {{$user->interests}}</p>
              
                            <div class="btn-group">
                                @php
                                    $userLiked = \App\Models\Like::where('user_id', auth()->id())->where('liked_user_id', $user->id)->exists();
                                @endphp

                                <button type="button" class="btn {{ $userLiked ? 'btn-success' : 'btn-primary' }} like-button" 
                                        data-user-id="{{ $user->id }}">
                                    {{ $userLiked ? '❤️ Liked' : '❤️ Like' }}
                                </button>

                                <button type="button" class="btn btn-secondary message-button" data-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#messageModal">
                                    💬 Chat
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</div>


<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Chat <span id="chatUserName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="chat-box" id="chatBox" style="height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                    <!-- Messages will be appended here -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type a message...">
                    <button class="btn btn-primary" id="sendMessageButton" data-user-id="">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@endsection
