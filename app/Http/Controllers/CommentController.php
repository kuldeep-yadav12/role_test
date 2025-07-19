<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'body'    => 'required|string|max:1000',
            'blog_id' => 'required|exists:blogs,id',
        ]);

        Comment::create([
            'body'    => $request->body,
            'blog_id' => $request->blog_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    public function like(Comment $comment)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->likes += 1;
        $comment->save();

        return response()->json(['success' => true, 'likes' => $comment->likes]);
    }

    public function destroy(Comment $comment)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment); // Use policy

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // Authorization (only owner can edit)
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->body = $request->body;
        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

}
