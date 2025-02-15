<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        // Fetch the three most recent users excluding the user with the name "super_admin"
        $users = User::where('name', '!=', 'super-admin')
                     ->orderBy('created_at', 'desc')
                     ->take(3)
                     ->get();
    
        return view('welcome', compact('users'));
    }

    public function about() {
        return view('about');
    }

    public function getUserById($id)
{
    $user = User::find($id);
    if ($user) {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
        ]);
    } else {
        return response()->json(['message' => 'User not found'], 404);
    }
}
}
