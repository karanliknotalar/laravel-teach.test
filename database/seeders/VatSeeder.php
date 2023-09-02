<?php

namespace Database\Seeders;

use App\Models\Vat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vat::create([
            "VAT" => 10,
        ]);
        Vat::create([
            "VAT" => 20,
        ]);
    }
}
