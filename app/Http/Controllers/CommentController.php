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
        $user = auth()->user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $existingLike = Like::where('user_id', $user->id)
            ->where('blog_id', $comment->blog_id)
            ->where('type', 'like')
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            Like::create([
                'user_id'    => auth()->id(),
                'comment_id' => $comment->id,
                'type'       => 'like',
            ]);

        }
        dd([
            'user_id'    => auth()->id(),
            'blog_id'    => $comment->blog_id ?? null,
            'comment_id' => $comment->id ?? null,
        ]);

        $likeCount = Like::where('blog_id', $comment->blog_id)
            ->where('type', 'like')
            ->count();

        return response()->json(['likes' => $likeCount]);

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

        if (auth()->id() !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'success'   => true,
            'user_name' => auth()->user()->name,
            'body'      => $comment->body,
        ]);
    }

}
