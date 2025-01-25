<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'], // Adjust max length as needed
            'age' => ['required', 'integer', 'min:1'], // Ensure age is a positive integer
            'gender' => ['required', 'in:male,female,other'], // Validate gender input
            'location' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:500'], // Adjust max length as needed
            'interests' => ['required', 'string', 'max:255'], // Adjust max length as needed
            'profile_picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Image validation
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

         // Handle file upload for the profile picture
        if (isset($data['profile_picture'])) {
            $profilePicturePath = $data['profile_picture']->store('profile_pictures', 'public'); // Store file in the 'public/profile_pictures' directory
        } else {
            $profilePicturePath = null; // Default value if no picture is uploaded
        }
         // Create and save the user
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'age' => $data['age'],
            'gender' => $data['gender'],
            'location' => $data['location'],
            'bio' => $data['bio'],
            'interests' => $data['interests'],
            'profile_picture' => $profilePicturePath, // Save the file path in the database
            'password' => Hash::make($data['password']),
        ]);
    }
}
