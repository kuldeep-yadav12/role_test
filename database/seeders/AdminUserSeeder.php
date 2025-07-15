<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
{
    User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'age' => 30,
        'gender' => 'Male',
        'phone' => '9999999999',
        'hobbies' => 'Management'
    ]);
}

}
