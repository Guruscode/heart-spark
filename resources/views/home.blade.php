@extends('layouts.app')

@section('content')
<div class="container-fluid">
@include('layouts.nav')
    
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
                        @if ($user->name !== 'super-admin')
                            <li class="list-group-item d-flex align-items-center">
                                <img 
                                    src="{{ asset('storage/' . $user->profile_picture) ?? 'https://via.placeholder.com/40' }}" 
                                    alt="{{ $user->name ?? 'Unnamed User' }}" 
                                    class="rounded-circle me-3" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                <span>{{ $user->name ?? 'Unnamed User' }}</span>
                            </li>
                        @endif
                    @empty
                        <li class="list-group-item">No recent users found.</li>
                    @endforelse
                </ul>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    Matches
                </div>
              <!-- Matches -->
<ul class="list-group list-group-flush">
    @forelse ($matches as $user)
        @if ($user->name !== 'super-admin')
            <li class="list-group-item d-flex align-items-center">
                <img 
                    src="{{ asset('storage/' . $user->profile_picture)  ?? 'https://via.placeholder.com/40' }}" 
                    alt="{{ $user->name ?? 'Unnamed User' }}" 
                    class="rounded-circle me-3" 
                    style="width: 40px; height: 40px; object-fit: cover;">
                <span>{{ $user->name ?? 'Unnamed User' }}</span>
            </li>
        @endif
    @empty
        <li class="list-group-item">No matches found.</li>
    @endforelse
</ul>
            </div>
            
        </div>

      
        <div class="col-lg-9">
         <!-- Main User Cards -->
<div class="row">
    @foreach($users as $user)
        @if ($user->name !== 'super-admin')
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
        @endif
    @endforeach
</div>
        </div>
        
    </div>
</div>


<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header text-white" style="background: linear-gradient(135deg, #6a11cb, #2575fc);">
                <h5 class="modal-title" id="messageModalLabel">
                    Chat with <span id="chatUserName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="chat-box p-3 rounded" id="chatBox" 
                     style="height: 300px; overflow-y: auto; background: #f8f9fa; border: 2px solid #6a11cb; border-radius: 10px;">
                    <!-- Messages will be appended here -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="messageInput" class="form-control rounded-pill" placeholder="Type a message...">
                    <button class="btn text-white ms-2 px-4 rounded-pill" id="sendMessageButton" data-user-id=""
                            style="background: linear-gradient(135deg, #ff416c, #ff4b2b);">
                        Send
                    </button>
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
