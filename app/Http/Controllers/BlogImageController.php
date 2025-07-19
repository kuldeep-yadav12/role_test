<?php

namespace App\Http\Controllers;

use App\Models\BlogImage;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class BlogImageController extends Controller
{
    public function reorder(Request $request)
{
    foreach ($request->order as $position => $id) {
        BlogImage::where('id', $id)->update(['sort_order' => $position]);
    }

    return response()->json(['success' => true]);
}


    public function deleteimg($id, Request $request)
    {
        $image = BlogImage::findOrFail($id);

        if (Storage::exists('public/' . $image->image_path)) {
            Storage::delete('public/' . $image->image_path);
        }

        $image->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }

        return back()->with('success', 'Image deleted successfully.');
    }
}
