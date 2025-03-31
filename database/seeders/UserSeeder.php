<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        DB::table('users')->insertOrIgnore([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Teacher',
                'email' => 'teacher@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'status' => 'active',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
} 