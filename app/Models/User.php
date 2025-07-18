<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;  

class User extends Authenticatable
{
    use SoftDeletes;  
   protected $fillable = [
        'name', 'email', 'gender', 'age', 'phone', 'hobbies', 'password', 'role'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class);
}

public function blogs()
{
    return $this->hasMany(Blog::class);
}

protected static function boot()
{
    parent::boot();

    static::restoring(function ($user) {
        \Log::info("Restoring user: " . $user->id); 
        $user->blogs()->withTrashed()->restore();
    });

    static::deleting(function ($user) {
        \Log::info("Deleting user: " . $user->id);
        if ($user->isForceDeleting()) {
            $user->blogs()->withTrashed()->forceDelete();
        } else {
            $user->blogs()->delete();
        }
    });
}



}
