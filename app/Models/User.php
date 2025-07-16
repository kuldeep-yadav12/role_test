<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

}
