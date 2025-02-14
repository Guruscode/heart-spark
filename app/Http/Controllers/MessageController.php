<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
  
    public function index()
    {
        $userId = auth()->id(); // Get the authenticated user's ID
        $projectId = 'heart-spark-2af15';
        $baseUrl = "https://firestore.googleapis.com/v1/projects/$projectId/databases/(default)/documents";
        $apiKey = 'AIzaSyBEX_fHfwQdQOX3IeL1CSznnIA67zga-ss';
    
        // Fetch all chat documents
        $response = Http::get("$baseUrl/chats", [
            'key' => $apiKey,
        ]);
    
        $chats = [];
    
        if ($response->ok()) {
            $documents = $response->json()['documents'] ?? [];
    
            foreach ($documents as $document) {
                $documentName = basename($document['name']);
                $participants = explode('_', $documentName);
    
                if (in_array($userId, $participants)) {
                    $otherUserId = $participants[0] == $userId ? $participants[1] : $participants[0];
                    $otherUser = \App\Models\User::find($otherUserId);
                    $otherUserName = $otherUser ? $otherUser->name : 'Unknown User';
                    $other_user_image = $otherUser ? $otherUser->profile_picture : 'Unknown Profile';
    
                    // Fetch messages from subcollection
                    $messagesResponse = Http::get("$baseUrl/chats/$documentName/messages", [
                        'key' => $apiKey,
                    ]);
    
                    if ($messagesResponse->ok()) {
                        $messagesData = $messagesResponse->json()['documents'] ?? [];
                        $allMessages = [];
    
                        foreach ($messagesData as $msg) {
                            $allMessages[] = [
                                'content' => $msg['fields']['message']['stringValue'] ?? 'No message',
                                'timestamp' => $msg['fields']['timestamp']['timestampValue'] ?? 'No timestamp',
                            ];
                        }
    
                        // Sort messages by timestamp
                        usort($allMessages, function ($a, $b) {
                            return strtotime($a['timestamp']) - strtotime($b['timestamp']);
                        });
    
                        $firstMessage = $allMessages[0] ?? null;
    
                        if ($firstMessage) {
                            $chats[] = [
                                'content' => $firstMessage['content'],
                                'timestamp' => $firstMessage['timestamp'],
                                'other_user_id' => $otherUserId,
                                'other_user_name' => $otherUserName,
                                'other_user_image' => $other_user_image,

                            ];
                        }
                    }
                }
            }
        }
    
        return view('messages.index', ['chats' => $chats]);
    }
    
    
    
    

    public function show($id) {
        $message = Message::findOrFail($id);
        $message->update(['is_read' => true]); // Mark as read

        return view('messages.show', compact('message'));
    }

    public function create() {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('messages.create', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);

        // Notify receiver
        Notification::create([
            'user_id' => $request->receiver_id,
            'type' => 'Message',
            'data' => json_encode(['message_id' => $message->id, 'sender' => Auth::user()->name]),
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully!');
    }

}
