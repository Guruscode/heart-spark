@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="my-4">Edit Profile</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $user->age) }}">
        </div>

        <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="male" {{ (old('gender', $user->gender) == 'male') ? 'selected' : '' }}>Male</option>
                <option value="female" {{ (old('gender', $user->gender) == 'female') ? 'selected' : '' }}>Female</option>
                <option value="other" {{ (old('gender', $user->gender) == 'other') ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location', $user->location) }}">
        </div>

        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div class="form-group">
            <label for="interests">Interests</label>
            @php
                // Decode interests as array, default to empty array if null or invalid
                $interestsArray = json_decode($user->interests, true);
                $interestsArray = is_array($interestsArray) ? $interestsArray : [];
            @endphp
            <input type="text" class="form-control" id="interests" name="interests" value="{{ old('interests', implode(', ', $interestsArray)) }}" placeholder="Comma separated">
            <small class="form-text text-muted">Enter your interests separated by commas.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
