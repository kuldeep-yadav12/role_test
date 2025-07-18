<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;  

class User extends Authenticatable
{
    use SoftDeletes;  
    protected $fillable = [
        'name',
        'email',
        'gender',
        'age',
        'phone',
        'hobbies',
        'password',
        'role',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
{
    return $this->hasMany(Like::class);
}


}
