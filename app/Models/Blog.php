<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'image', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class);
}

public function images()
{
    return $this->hasMany(BlogImage::class);
}

}
