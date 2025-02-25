@extends('layouts.app')

@section('content')
<div class="container-fluid">
   @include('layouts.nav')

    <!-- ✅ Profile Section -->
    <div class="container" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 text-center" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); border-radius: 15px;">
                    <div class="card-body">
                        <div class="position-relative d-inline-block">
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" class="rounded-circle border shadow-sm"
                                 style="width: 130px; height: 130px; object-fit: cover; transition: transform 0.3s;">
                        </div>
                        <h3 class="mt-3 text-primary">{{ $user->name }}</h3>
                        <p class="text-muted">{{ $user->location ?? 'Unknown Location' }}</p>
                        <p class="text-muted">Interests: {{ $user->interests ?? 'Not specified' }}</p>
                        
                        <div class="d-flex justify-content-around mt-4">
                            <div>
                                <h5 class="fw-bold text-success">120</h5>
                                <p class="text-muted">Matches</p>
                            </div>
                            <div>
                                <h5 class="fw-bold text-danger">75</h5>
                                <p class="text-muted">Messages</p>
                            </div>
                            <div>
                                <h5 class="fw-bold text-info">89</h5>
                                <p class="text-muted">Profile Visits</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary px-4">Edit Profile</a>
                            <a href="#" class="btn btn-primary px-4">Upgrade</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ People Who Liked You -->
    <div class="container mt-5">
        <h2 class="text-center text-danger">People Who Liked You ❤️</h2>
        <div class="row">
            @forelse($users as $user)
                <div class="col-md-4 col-lg-3 col-sm-6 mb-4">
                    <div class="card shadow-lg border-0" style="border-radius: 15px; transition: transform 0.3s;">
                        <div class="position-relative">
                            <img class="card-img-top rounded-top" src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                            <span class="badge badge-danger position-absolute" style="top: 10px; left: 10px;">❤️ Liked You</span>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $user->name }}</h5>
                            <p class="text-muted">Age: {{ $user->age }} | {{ $user->location }}</p>

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
            @empty
                <p class="text-center w-100 text-muted">No one has liked you yet 😢</p>
            @endforelse
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


<!-- ✅ jQuery & Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

@endsection
