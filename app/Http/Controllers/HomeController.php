<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $users = User::all(); // Fetch all users from the database
        $userId = auth()->id();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $users = User::where('id', '!=', auth()->id())->get();
        $matches = User::whereHas('likes', function ($query) use ($userId) {
            $query->where('liked_user_id', $userId);
        })->get();
        return view('home', compact('users', 'recentUsers', 'matches'));
    }
}
