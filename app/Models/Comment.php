<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'blog_id', 'body'];

  public function user()
{
    return $this->belongsTo(User::class);
}

public function blog()
{
    return $this->belongsTo(Blog::class);
}

public function likes()
{
    return $this->hasMany(Like::class);
}





}
