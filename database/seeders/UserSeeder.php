<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'), // Gunakan hashing untuk keamanan password
            ],
            [
                'id' => 2,
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'), // Gunakan hashing untuk keamanan password
            ],
        ]);
    }
}
