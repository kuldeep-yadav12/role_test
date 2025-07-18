<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index(Request $request)
    {
        if (auth()->user()->role === 'admin') {
            $blogs     = Blog::latest()->simplePaginate(3);
            $postCount = Blog::count();
        } else {
            $blogs     = Blog::where('user_id', auth()->id())->latest()->simplePaginate(3);
            $postCount = Blog::where('user_id', auth()->id())->count();
        }

        if ($request->ajax()) {
            return view('blogs.main_blogs.blogs', compact('blogs', 'postCount'))->render();
        }

        return view('blogs.main_blogs.index', compact('blogs', 'postCount'));
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

        // $request->validate([
        //     'title'   => 'required',
        //     'content' => 'required',
        //     'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        // ]);

        // $data = $request->only(['title', 'content']);

        // if ($request->hasFile('image')) {
        //     $imagePath     = $request->file('image')->store('blogs', 'public');
        //     $data['image'] = $imagePath;
        // }
        // $data['user_id'] = auth()->id();

        // Blog::create($data);

        // return redirect()->route('blog.main_blog.index')->with('success', 'Blog created!');

       
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->only(['title', 'content']);
    $data['user_id'] = auth()->id();

    $blog = Blog::create($data);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('blogs', 'public');
            $blog->images()->create(['image_path' => $path]);
        }
    }

    return redirect()->route('blog.main_blog.index')->with('success', 'Blog created!');
}


    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
            abort(403);
        }

        return view('blogs.main_blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);

        if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
            abort(403);
        }

        return view('blogs.main_blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $blog = Blog::findOrFail($id);

        // // Prevent unauthorized users from editing
        // if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
        //     abort(403);
        // }

        // $request->validate([
        //     'title'   => 'required',
        //     'content' => 'required',
        //     'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        // ]);

        // $data = $request->only(['title', 'content']);

        // // Handle image upload
        // if ($request->hasFile('image')) {
        //     $imagePath     = $request->file('image')->store('blogs', 'public');
        //     $data['image'] = $imagePath;
        // }

        // $blog->update($data);

         $blog = Blog::findOrFail($id);

    if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'remove_images' => 'array'
    ]);

    $data = $request->only(['title', 'content']);
    $blog->update($data);

    // Remove selected images
    if ($request->has('remove_images')) {
        foreach ($request->remove_images as $imageId) {
            $image = $blog->images()->find($imageId);
            if ($image) {
                \Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
    }
    // Add new images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('blogs', 'public');
            $blog->images()->create(['image_path' => $path]);
        }
    }
        return redirect()->route('blog.main_blog.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('blog.main_blog.index')->with('success', 'Blog deleted successfully!');
    }

public function blogFilter(Request $request)
{
    $query = Blog::query();

    if ($request->filled('title')) {
        $query->where('title', 'like', '%' . $request->title . '%');
    }

    if ($request->filled('start_date')) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }
     $blogs = $query->latest()->paginate(3);

    if ($request->ajax()) {
        return view('blogs.main_blogs.blogs', compact('blogs'))->render();
    }

    return view('blogs.main_blogs.index', compact('blogs'));
}



}
