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
                'item_category_id' => 1,
                'location_id' => 1,
                'item_status_id' => 2,
                'name' => 'Smartphone',
                'description' => 'Iphone, black color.',
                'location_found' => 'Perpustakaan Gedung W',
                'time_found' => now(),
                'image' => 'images/1733564176_iphone12_hitam.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Pencil Case',
                'description' => 'Pencil Case, blue color.',
                'location_found' => 'Lab SI Gedung P',
                'time_found' => now(),
                'image' => 'images/1733508029_PencilCase.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Pencil Case',
                'description' => 'Pencil Case, blue color.',
                'location_found' => 'Lab SI Gedung P',
                'time_found' => now(),
                'image' => 'images/1733508029_PencilCase.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Pencil Case',
                'description' => 'Pencil Case, blue color.',
                'location_found' => 'Lab SI Gedung P',
                'time_found' => now(),
                'image' => 'images/1733508029_PencilCase.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Pencil Case',
                'description' => 'Pencil Case, blue color.',
                'location_found' => 'Lab SI Gedung P',
                'time_found' => now(),
                'image' => 'images/1733508029_PencilCase.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Pencil Case',
                'description' => 'Pencil Case, blue color.',
                'location_found' => 'Lab SI Gedung P',
                'time_found' => now(),
                'image' => 'images/1733508029_PencilCase.jpg', // Gambar placeholder
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
