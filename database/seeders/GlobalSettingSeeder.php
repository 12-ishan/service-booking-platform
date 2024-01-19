<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\GlobalSetting;

class GlobalSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        GlobalSetting::create([
            'application_table_order' => json_encode([
                ['column' => 'full_name', 'title' => 'Full Name', 'visibleStatus' => 1],

                // ['column' => 'student.first_name', 'title' => 'Student Name', 'visibleStatus' => 1],
                
                ['column' => 'application_number', 'title' => 'App number', 'visibleStatus' => 1],
                ['column' => 'start_time', 'title' => 'Start Time', 'visibleStatus' => 1],
                ['column' => 'end_time', 'title' => 'End Time', 'visibleStatus' => 1],
                ['column' => 'last_date', 'title' => 'Last Date', 'visibleStatus' => 1],
               



              
                // Add more columns as needed
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
