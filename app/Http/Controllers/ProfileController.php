<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();
        
        $users = User::whereIn('id', function ($query) {
            $query->select('user_id')
                  ->from('likes')
                  ->where('liked_user_id', Auth::id());
        })->get();
        
        // Return the profile view with user data
        return view('profile.show', compact('user', "users"));
    }
    public function edit()
{
    // Get the authenticated user
    $user = Auth::user();

    // Return the profile edit view with user data
    return view('profile.edit', compact('user'));
}

public function update(Request $request)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'phone' => 'nullable|string|max:15',
        'age' => 'nullable|integer|min:0', // Validate age
        'gender' => 'nullable|string|in:male,female,other', // Validate gender
        'location' => 'nullable|string|max:255', // Validate location
        'bio' => 'nullable|string|max:500', // Validate bio
        'interests' => 'nullable|array', // Validate interests as an array
        'interests.*' => 'string|max:100', // Each interest should be a string
    ]);

    // Get the authenticated user
    $user = Auth::user();

    // Update user details
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->age = $request->age; // Add age
    $user->gender = $request->gender; // Add gender
    $user->location = $request->location; // Add location
    $user->bio = $request->bio; // Add bio
    $user->interests = json_encode($request->interests); // Store interests as JSON
    $user->save();

    // Redirect back to profile with success message
    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}


}
