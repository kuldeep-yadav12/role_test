<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'body'    => 'required|string|max:1000',
        'blog_id' => 'required|exists:blogs,id',
    ]);

    Comment::create([
        'user_id' => auth()->id(),
        'blog_id' => $request->blog_id,
        'body'    => $request->body,
    ]);

    return back()->with('success', 'Comment added!');
}

}
