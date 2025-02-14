<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        return view('welcome');
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
