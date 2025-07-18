<?php

namespace App\Http\Controllers;
use App\Models\BlogImage;
use App\Models\Blog;

use Illuminate\Http\Request;

class BlogImageController extends Controller
{
public function reorder(Request $request)
{
    foreach ($request->order as $item) {
        BlogImage::where('id', $item['id'])->update(['sort_order' => $item['position']]);
    }

    return response()->json(['success' => true]);
}

}
