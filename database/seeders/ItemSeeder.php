<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('items')->insert([
            [
                'user_id'=> null,
                'item_category_id' => 1,
                'location_id' => 1,
                'item_status_id' => 2,
                'name' => 'Smartphone',
                'description' => 'Iphone, black color.',
                'location_found' => 'Perpustakaan Gedung W',
                'time_found' => now(),
                'image' => 'images/iphone_hitam.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
