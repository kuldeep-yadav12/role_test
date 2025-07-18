<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function show($id)
    {
        $blog = Blog::with('comments.user')->findOrFail($id);
        return view('comments.show', compact('blog'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
            'blog_id' => 'required|exists:blogs,id',
        ]);

        Comment::create([
            'body' => $request->body,
            'blog_id' => $request->blog_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }
}
