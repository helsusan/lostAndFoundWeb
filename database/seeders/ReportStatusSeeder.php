<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('report_statuses')->insert([
            [
                'name' => 'Found',  
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Not Found',  
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
