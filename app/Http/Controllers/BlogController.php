<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $blogs = Blog::latest()->simplepaginate(2);
    //     return view('blogs.main_blogs.index', compact('blogs'));

    // }

//  public function index(Request $request)
// {
//     $blogs = Blog::latest()->simplePaginate(2);

//     if ($request->ajax()) {
//         return view('blogs.main_blogs.blogs', compact('blogs'))->render();
//     }

//     return view('blogs.main_blogs.index', compact('blogs'));
// }

    public function index(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            $blogs = Blog::latest()->simplePaginate(2);
        } else {
            $blogs = Blog::where('user_id', auth()->id())->latest()->simplePaginate(2);
        }

        if ($request->ajax()) {
            return view('blogs.main_blogs.blogs', compact('blogs'))->render();
        }

        return view('blogs.main_blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.main_blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            $imagePath     = $request->file('image')->store('blogs', 'public');
            $data['image'] = $imagePath;
        }

        $data['user_id'] = auth()->id(); // ✅ Assign current user's ID

        Blog::create($data);

        return redirect()->route('blog.main_blog.index')->with('success', 'Blog created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // Only show if it's the user's own blog or the user is admin
        if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
            abort(403); // Forbidden
        }

        return view('blogs.main_blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
