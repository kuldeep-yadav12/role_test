<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLikeDislike(Request $request)
{
    $request->validate([
        'blog_id' => 'required|exists:blogs,id',
        'type' => 'required|in:like,dislike',
    ]);

    $like = Like::where('user_id', Auth::id())
                ->where('blog_id', $request->blog_id)
                ->first();

    if ($like) {
        if ($like->type === $request->type) {
            $like->delete(); 
        } else {
            $like->update(['type' => $request->type]);
        }
    } else {
        Like::create([
            'user_id' => Auth::id(),
            'blog_id' => $request->blog_id,
            'type' => $request->type,
        ]);
    }

    $likes = Like::where('blog_id', $request->blog_id)->where('type', 'like')->count();
    $dislikes = Like::where('blog_id', $request->blog_id)->where('type', 'dislike')->count();

    return response()->json([
        'likes' => $likes,
        'dislikes' => $dislikes
    ]);
}

}