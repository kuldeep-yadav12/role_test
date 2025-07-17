<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function LikeDislike(Request $request, Blog $blog)
    {
        $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $like = Like::where('user_id', auth()->id())
            ->where('blog_id', $blog->id)
            ->first();

        if ($like) {
            if ($like->type === $request->type) {
                $like->delete();
            } else {
                $like->update(['type' => $request->type]);
            }
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'blog_id' => $blog->id,
                'type'    => $request->type,
            ]);
        }

        return back()->with('success', 'Your feedback was recorded.');
    }
}


