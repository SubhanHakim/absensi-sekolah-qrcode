<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        User::create([
            'name' => 'Wali Kelas',
            'email' => 'petugas@example.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);
    }
}