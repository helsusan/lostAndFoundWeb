<?php

namespace Database\Seeders;

use DB;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Jane Smith',
                'email' => 'janesmith@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '082345678901',
                'role_id' => 1, 
            ],
            [
                'name' => 'John Doe',
                'email' => 'johndoe@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),  // Hash password
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '081234567890',
                'role_id' => 2,
            ],
        ]);
    }
}
