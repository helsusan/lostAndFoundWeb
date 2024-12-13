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
            //Admin User
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
            //Regular User
            [
                'name' => 'John Doe',
                'email' => 'johndoe@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'), 
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '081234567890',
                'role_id' => 2,
            ],
            [
                'name' => 'Bob Brown',
                'email' => 'bobbrown@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '083123456789',
                'role_id' => 2,
            ],
            [
                'name' => 'Charlie White',
                'email' => 'charliewhite@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '084234567890',
                'role_id' => 2, 
            ],
            [
                'name' => 'David Green',
                'email' => 'davidgreen@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '085345678901',
                'role_id' => 2, 
            ],
            [
                'name' => 'Eva Blue',
                'email' => 'evablue@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '086456789012',
                'role_id' => 2, 
            ],
            [
                'name' => 'Frank Yellow',
                'email' => 'frankyellow@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '087567890123',
                'role_id' => 2, 
            ],
            [
                'name' => 'George Black',
                'email' => 'georgeblack@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '088678901234',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Hannah Gray',
                'email' => 'hannahgray@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '089789012345',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Isaac Pink',
                'email' => 'isaacpink@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '090890123456',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Jack Red',
                'email' => 'jackred@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '091901234567',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Katie Purple',
                'email' => 'katiepurple@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '092012345678',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Liam Orange',
                'email' => 'liamorange@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '093123456789',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Mia Silver',
                'email' => 'miasilver@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '094234567890',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Noah Gold',
                'email' => 'noahgold@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '095345678901',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Olivia Brown',
                'email' => 'oliviabrown@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '096456789012',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Paul White',
                'email' => 'paulwhite@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '097567890123',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Quincy Blue',
                'email' => 'quincyblue@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '098678901234',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Rachel Green',
                'email' => 'rachelgreen@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '099789012345',
                'role_id' => 2, // User role
            ],
            [
                'name' => 'Samuel Black',
                'email' => 'samuelblack@user.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
                'phone_number' => '100890123456',
                'role_id' => 2, // User role
            ],
        ]);
    }
}
