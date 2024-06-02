<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\GeneralSettings;

class GeneralSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $generalSettings = new GeneralSettings();
       $generalSettings->type = "contact";
       $generalSettings->phone = "+01 123455678990";
       $generalSettings->email = "demo@gmail.com";
       $generalSettings->location = " Lorem Ipsum is simply dummy text";
       $generalSettings->max_records = "5";
       $generalSettings->save();
    }
}
