<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
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

        foreach ($categories as $category) {

            for ($i = 0; $i < random_int(4, 6); $i++) {

                $base = $category->base_category->name ?? "";
                $base = $base == "" ? "" : $base . " - ";
                $name = $base . $category->name . " - Ürün " . random_int(100, 999);

                Product::create([
                    "category_id" => $category->id,
                    "name" => $name,
                    "slug_name" => Str::slug($name),
                    "image" => null,
                    "description" => "Uzun Açıklama",
                    "sort_description" => "Kısa Açıklama",
                    "size" => ["Small", "Large", "Medium"][random_int(0, 2)],
                    "color" => ["Red", "Green", "Blue", "Purple"][random_int(0, 3)],
                    "quantity" => rand(1, 99),
                    "status" => 1
                ]);
            }
        }
    }
}
