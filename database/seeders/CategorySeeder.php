<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        CategoryFactory::times(3)->create();
//        Category::factory(10)->create();

        $erkek = Category::create([
            "name" => "Erkek",
            "parent_id" => null,
            "slug_name" => Str::slug("Erkek"),
            "description" => "Erkek Giyim",
            "seo_description" => "Erkek Giyim",
            "seo_keywords" => Str::slug("Erkek Giyim", ","),
            "status" => "1",
            "image" => "images/men.jpg",
            "thumbnail" => null,
            "order" => 1,
        ]);

        Category::create([
            "name" => "Kazak",
            "parent_id" => $erkek->id,
            "slug_name" => Str::slug("Erkek Kazak"),
            "description" => "Erkek Kazak",
            "seo_description" => "Erkek Kazak",
            "seo_keywords" => Str::slug("Erkek Kazak", ","),
            "status" => "1",
            "image" => fake()->imageUrl,
            "thumbnail" => null,
            "order" => 1,
        ]);

        Category::create([
            "name" => "Gömlek",
            "parent_id" => $erkek->id,
            "slug_name" => Str::slug("Erkek Gömlek"),
            "description" => "Erkek Gömlek",
            "seo_description" => "Erkek Gömlek",
            "seo_keywords" => Str::slug("Erkek Gömlek", ","),
            "status" => "1",
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => 2,
        ]);


        $kadin = Category::create([
            "name" => "Kadın",
            "parent_id" => null,
            "slug_name" => Str::slug("Kadın"),
            "description" => "Kadın Giyim",
            "seo_description" => "Kadın Giyim",
            "seo_keywords" => Str::slug("Kadın Giyim", ","),
            "status" => 1,
            "image" => "images/women.jpg",
            "thumbnail" => null,
            "order" => 2,
        ]);

        Category::create([
            "name" => "Kazak",
            "parent_id" => $kadin->id,
            "slug_name" => Str::slug("Kadın Kazak"),
            "description" => "Kadın Kazak",
            "seo_description" => "Kadın Kazak",
            "seo_keywords" => Str::slug("Kadın Kazak", ","),
            "status" => "1",
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => 1,
        ]);

        Category::create([
            "name" => "Gömlek",
            "parent_id" => $kadin->id,
            "slug_name" => Str::slug("Kadın Gömlek"),
            "description" => "Kadın Gömlek",
            "seo_description" => "Kadın Gömlek",
            "seo_keywords" => Str::slug("Kadın Gömlek", ","),
            "status" => "1",
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => 2,
        ]);

        $cocuk = Category::create([
            "name" => "Çocuk",
            "parent_id" => null,
            "slug_name" => Str::slug("Çocuk"),
            "description" => "Çocuk Giyim",
            "seo_description" => "Çocuk Giyim",
            "seo_keywords" => Str::slug("Çocuk Giyim", ","),
            "status" => 1,
            "image" => "images/children.jpg",
            "thumbnail" => null,
            "order" => 3,
        ]);

        Category::create([
            "name" => "Oyuncak",
            "parent_id" => $cocuk->id,
            "slug_name" => Str::slug("Çocuk Oyuncak"),
            "description" => "Çocuk Oyuncak",
            "seo_description" => "Çocuk Oyuncak",
            "seo_keywords" => Str::slug("Çocuk Oyuncak", ","),
            "status" => 1,
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => 1,
        ]);

        Category::create([
            "name" => "T-Shirt",
            "parent_id" => $cocuk->id,
            "slug_name" => Str::slug("Çocuk T-Shirt"),
            "description" => "Çocuk T-Shirt",
            "seo_description" => "Çocuk T-Shirt",
            "seo_keywords" => Str::slug("Çocuk T-Shirt", ","),
            "status" => 1,
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => 2,
        ]);
    }
}
