<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
