<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Iphone, Black, lost in the library.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Library, Building W',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
