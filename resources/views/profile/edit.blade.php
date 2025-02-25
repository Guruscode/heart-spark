@extends('layouts.app')

@section('content')
@include('layouts.nav')
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
        <div class="mb-3">
            <label for="interests" class="form-label">Interests</label>
            <select id="interests" class="form-select" name="interests" required>
                <option value="">Select your interest</option>
                <option value="{{ (old('interests', $user->interests) == 'aries') ? 'selected' : '' }}">Aries</option>
                <option value="{{ (old('interests', $user->interests) == 'taurus') ? 'selected' : '' }}">Taurus</option>
                <option value="{{ (old('interests', $user->interests) == 'gemini') ? 'selected' : '' }}">Gemini</option>
                <option value="{{ (old('interests', $user->interests) == 'cancer') ? 'selected' : '' }}">Cancer</option>
                <option value="{{ (old('interests', $user->interests) == 'leo') ? 'selected' : '' }}">Leo</option>
                <option value="{{ (old('interests', $user->interests) == 'virgo') ? 'selected' : '' }}">Virgo</option>
                <option value="{{ (old('interests', $user->interests) == 'libra') ? 'selected' : '' }}">Libra</option>
                <option value="{{ (old('interests', $user->interests) == 'scorpio') ? 'selected' : '' }}">Scorpio</option>
                <option value="{{ (old('interests', $user->interests) == 'sagittarius') ? 'selected' : '' }}">Sagittarius</option>
                <option value="{{ (old('interests', $user->interests) == 'capricorn') ? 'selected' : '' }}">Capricorn</option>
                <option value="{{ (old('interests', $user->interests) == 'aquarius') ? 'selected' : '' }}">Aquarius</option>
                <option value="{{ (old('interests', $user->interests) == 'pisces') ? 'selected' : '' }}">Pisces</option>
            </select>
        </div>

       

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
