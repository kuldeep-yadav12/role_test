<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogMedia;
use App\Models\BlogImage;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class BlogController extends Controller
{

    public function index(Request $request)
{
    
    $activeTab = $request->get('tab', 'all');

    if (auth()->user()->role === 'admin') {

        
        $blogs = Blog::with(['user','comments.user','likes','images'])
                     ->latest()
                     ->paginate(3, ['*'], 'all_page');

        
        $trashedBlogs = Blog::onlyTrashed()
                            ->with(['user','comments.user','likes','images'])
                            ->latest()
                            ->paginate(3, ['*'], 'trash_page');

    } else {
        $blogs = Blog::with(['user','comments.user','likes','images'])
                     ->where('user_id', auth()->id())
                     ->latest()
                     ->paginate(3, ['*'], 'all_page');

        $trashedBlogs = Blog::onlyTrashed()
                            ->with(['user','comments.user','likes','images'])
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->paginate(3, ['*'], 'trash_page');
    }

    if ($request->ajax()) {
        return view(
            'blogs.main_blogs.blogs',
            ['blogs' => $activeTab === 'trash' ? $trashedBlogs : $blogs,
             'isTrash' => $activeTab === 'trash']
        )->render();
        return $view;
    }

    return view('blogs.main_blogs.index',
                compact('blogs','trashedBlogs','activeTab'));
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
        'title'    => 'required',
        'content'  => 'required',
        'media.*'  => 'file|mimes:jpeg,png,jpg,mp4,webm,ogg|max:51200', // 50MB
    ]);

    $data = $request->only(['title', 'content']);
    $data['user_id'] = auth()->id();
    $blog = Blog::create($data);

    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $file) {
            $path = $file->store('blogs', 'public');
            $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
            $blog->media()->create([
                'file_path' => $path,
                'type'      => $type,
            ]);
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
    
public function update(Request $request, Blog $blog,string $id)
{
     $blog = Blog::findOrFail($id);

    if (auth()->user()->role !== 'admin' && $blog->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'media.*' => 'file|mimes:jpeg,png,jpg,mp4,webm,ogg|max:51200',
    ]);

    $blog->update([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    // Upload new media
    if ($request->hasFile('media')) {
        foreach ($request->file('media') as $file) {
            $path = $file->store('blogs', 'public');
            $type = str_starts_with($file->getMimeType(), 'video') ? 'video' : 'image';
            $blog->media()->create([
                'file_path' => $path,
                'type' => $type,
            ]);
        }
    }

    return redirect()->route('blog.main_blog.index')->with('success', 'Blog updated!');
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
    $activeTab = $request->get('tab', 'all');

    // Common filter for both live & trash
    $applyFilters = function ($query) use ($request) {
        if ($request->filled('title')) {
            $query->where('title','like','%'.$request->title.'%');
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at','>=',$request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at','<=',$request->end_date);
        }
    };

    // live blogs
    $blogs = Blog::query();          
    $applyFilters($blogs);
    $blogs = $blogs->latest()->paginate(3, ['*'], 'all_page');

    // trashed blogs
    $trashedQuery = Blog::onlyTrashed();  
    $applyFilters($trashedQuery);
    $trashedBlogs = $trashedQuery->latest()->paginate(3, ['*'], 'trash_page');

    if ($request->ajax()) {
        return view('blogs.main_blogs.blogs', [
            'blogs'   => $activeTab==='trash' ? $trashedBlogs : $blogs,
            'isTrash' => $activeTab==='trash'
        ])->render();
    }

    return view('blogs.main_blogs.index',
                compact('blogs','trashedBlogs','activeTab'));
}

    public function toggleLikeDislike(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'type'    => 'required|in:like,dislike',
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
                'type'    => $request->type,
            ]);
        }

        $likes    = Like::where('blog_id', $request->blog_id)->where('type', 'like')->count();
        $dislikes = Like::where('blog_id', $request->blog_id)->where('type', 'dislike')->count();

        return response()->json([
            'likes'    => $likes,
            'dislikes' => $dislikes,
        ]);
    }

    public function deleteImage(Request $request, $id)
    {
    $media = BlogMedia::findOrFail($id);

    if (Storage::disk('public')->exists($media->file_path)) {
        Storage::disk('public')->delete($media->file_path);
    }

    $media->delete();

    return response()->json(['success' => true, 'message' => 'Media deleted successfully.']);
}

    public function reorderImages(Request $request)
    {
        foreach ($request->order as $position => $id) {
            BlogMedia::where('id', $id)->update(['sort_order' => $position]);
        }

        return response()->json(['success' => true]);
    }


 public function restore($id)
{
    $blog = Blog::onlyTrashed()->findOrFail($id);

    // Check if user exists
    if (!User::where('id', $blog->user_id)->exists()) {
        return redirect()->back()->with('error', 'Cannot restore. Blog owner does not exist.');
    }

    // Check if user is authorized (admin or blog owner)
    if (Auth::user()->role === 'admin' || Auth::id() === $blog->user_id) {
        $blog->restore();
        return redirect()->route('blog.main_blog.index', ['tab' => 'trash'])
                         ->with('success', 'Blog restored successfully!');
    } else {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }
}


    // Permanently delete a soft-deleted blog
    public function forceDelete($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);

        // Check if user is authorized (admin or blog owner)
        if (Auth::user()->role === 'admin' || Auth::id() === $blog->user_id) {
            $blog->forceDelete();
            return redirect()->route('blog.main_blog.index', ['tab' => 'trash'])
                           ->with('success', 'Blog permanently deleted!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }
}
