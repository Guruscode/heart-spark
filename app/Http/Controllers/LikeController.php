<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function likeUser(Request $request)
    {
        $request->validate([
            'liked_user_id' => 'required|exists:users,id',
        ]);
    
        $userId = auth()->id();
        $likedUserId = $request->input('liked_user_id');
    
        $likedUser = User::find($likedUserId);
    
        // Fetch the max likes setting
        $maxLikes = Settings::where('key', 'free_user_max_likes')->value('value') ?? 10;
    
        // Check if the authenticated user has exceeded their like limit
        $currentLikesCount = Like::where('user_id', $userId)->count();
        if (auth()->user()->subscription_type === 'free' && $currentLikesCount >= $maxLikes) {
            return response()->json([
                'message' => 'You have reached the maximum likes for a free account. Please upgrade to continue liking more users.',
                'upgrade_required' => true, // Include a flag for the front-end to handle prompts
            ], 403);
        }
    
        $existingLike = Like::where('user_id', $userId)
            ->where('liked_user_id', $likedUserId)
            ->first();
    
        if ($existingLike) {
            return response()->json(['message' => 'You already liked this user'], 200);
        }
    
        // Save the like record
        Like::create([
            'user_id' => $userId,
            'liked_user_id' => $likedUserId,
        ]);
    
        // Increment the likes received count for the liked user
        $likedUser->increment('likes_received');
    
        return response()->json([
            'message' => 'User liked successfully!',
            'upgrade_required' => false, // No need to upgrade in this case
        ], 201);
    }
    
}
