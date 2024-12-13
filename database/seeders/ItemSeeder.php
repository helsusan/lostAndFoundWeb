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
                'description' => 'Iphone warna hitam.',
                'location_found' => 'Collab room A di atas meja',
                'time_found' => now(),
                'image' => 'images/1733564176_iphone12_hitam.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 2,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Tepak Pensil',
                'description' => 'Tepak pensil warna biru.',
                'location_found' => 'Meja Lab SI berisan ke tiga dari depan',
                'time_found' => now(),
                'image' => 'images/Tepak_Pensil_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 3,
                'location_id' => 3,
                'item_status_id' => 2,
                'name' => 'Anting',
                'description' => 'Anting emas berbetuk bunga.',
                'location_found' => 'Meja barisan ke kelima dari belakang',
                'time_found' => now(),
                'image' => 'images/anting_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 6,
                'location_id' => 4,
                'item_status_id' => 2,
                'name' => 'Buku Tulis',
                'description' => 'Buku tulis warna merah.',
                'location_found' => 'Meja depan stan carnival',
                'time_found' => now(),
                'image' => 'images/buku_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 3,
                'location_id' => 5,
                'item_status_id' => 2,
                'name' => 'kalung',
                'description' => 'kalung emas berbentuk air drop.',
                'location_found' => 'Sisi kiri auditorium, barisan ke tiga dari depan',
                'time_found' => now(),
                'image' => 'images/kalung_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_category_id' => 5,
                'location_id' => 2,
                'item_status_id' => 2,
                'name' => 'Kunci',
                'description' => 'Kunci warna Silver.',
                'location_found' => ' Gedung p	Di atas meja, barisan ke dua dari depan',
                'time_found' => now(),
                'image' => 'images/kunci_2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
