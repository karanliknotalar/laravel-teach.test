<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            "title" => "Free Shipping *",
            "content" => "*Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.",
            "icon" => "icon-truck",
            "status" => 1,
        ]);

        Service::create([
            "title" => "Free Returns *",
            "content" => "*Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.",
            "icon" => "icon-refresh2",
            "status" => 1,
        ]);

        Service::create([
            "title" => "Free Returns *",
            "content" => "*Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at iaculis quam. Integer accumsan tincidunt fringilla.",
            "icon" => "icon-help",
            "status" => 1,
        ]);
    }
}
