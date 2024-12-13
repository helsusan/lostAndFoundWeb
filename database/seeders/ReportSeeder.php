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
                'description' => 'Merek Iphone warna hitam.',
                'image' => 'images/1733564014_iphone_black.jpg',
                'is_verified' => false,
                'location_lost' => 'Collab room A di atas meja',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'location_id' => 2,
                'report_status_id' => 2,
                'description' => 'Kotak pensil kain warna biru.',
                'image' => 'images/Tepak_Pensil.jpg',
                'is_verified' => false,
                'location_lost' => 'Meja Lab SI berisan ke tiga dari depan',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'location_id' => 3,
                'report_status_id' => 2,
                'description' => 'Anting emas bentuk bunga.',
                'image' => 'images/anting.jpg',
                'is_verified' => false,
                'location_lost' => 'Meja barisan ke kelima dari belakang',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'location_id' => 4,
                'report_status_id' => 2,
                'description' => 'Buku tulis merah.',
                'image' => 'images/buku.jpg',
                'is_verified' => false,
                'location_lost' => 'Meja depan stan carnival',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'location_id' => 5,
                'report_status_id' => 2,
                'description' => 'Kalung emas berbentuk air drop.',
                'image' => 'images/kalung.jpg',
                'is_verified' => false,
                'location_lost' => 'Sisi kiri auditorium, barisan ke tiga dari depan',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'location_id' => 1,
                'report_status_id' => 2,
                'description' => 'Kertas jawaban ujian WFD.',
                'image' => 'images/kertas.jpg',
                'is_verified' => false,
                'location_lost' => 'Collab room B di atas meja',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'location_id' => 2,
                'report_status_id' => 2,
                'description' => 'Kunci rumah warna silver dan ada gantungan rumahnya.',
                'image' => 'images/kunci.jpg',
                'is_verified' => false,
                'location_lost' => 'Di atas meja, barisan ke dua dari depan',
                'time_lost' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
