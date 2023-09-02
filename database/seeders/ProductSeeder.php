<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Vat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Product::factory(30)->create();
        $categories = Category::query()->with("base_category")->get();
        $featuredC = 0;
        foreach ($categories as $category) {

            for ($i = 0; $i < random_int(3, 4); $i++) {

                $base = $category->base_category->name ?? "";
                $base = $base == "" ? "" : $base . " - ";
                $name = $base . $category->name . " - Ürün " . random_int(100, 999);
                $featuredC += 1;
                Product::create([
                    "category_id" => $category->id,
                    "name" => $name,
                    "slug_name" => Str::slug($name),
                    "product_code" => "ABC".random_int(1000,9999),
                    "image" => null,
                    "description" => "Uzun Açıklama",
                    "sort_description" => "Kısa Açıklama",
                    "VAT_id" => 2,
                    "status" => 1,
                    "featured" => $featuredC < 5 ? 1 : 0
                ]);
            }
        }
    }
}
