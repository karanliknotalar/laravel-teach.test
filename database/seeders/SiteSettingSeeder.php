<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            "name" => "address",
            "content" => "Bla bla mahallesi. Bla bla Sk. No: 999 Blabla/BLABLA",
            "type"=> "text"
        ]);

        SiteSetting::create([
            "name" => "phone",
            "content" => "+905551112233",
            "type"=> "text"
        ]);

        SiteSetting::create([
            "name" => "email",
            "content" => "blablabla@blablana.com",
            "type"=> "email"
        ]);
    }
}
