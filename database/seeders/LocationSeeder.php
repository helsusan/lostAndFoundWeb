<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            [
                'name' => 'Perpustakaan',
                'building' => 'Gedung W',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lab SI',
                'building' => 'Gedung p',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kelas P201',
                'building' => 'Gedung P',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kantin',
                'building' => 'Gedung Q',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Auditorium',
                'building' => 'Gedung Q',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
