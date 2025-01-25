<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function inbox()
    {
        // // Fetch messages where the user is the recipient
        // $messages = Auth::user()->messages()->with('sender')->get();
    
        return view('chat.inbox', );
    }
}
