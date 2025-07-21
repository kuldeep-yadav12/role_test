<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogMedia extends Model
{
   protected $fillable = ['blog_id', 'file_path', 'type', 'sort_order'];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
