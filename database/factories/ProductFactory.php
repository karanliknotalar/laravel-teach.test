<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = "Ürün " . random_int(100, 999);

        return [
            "category_id" => random_int(1, 9),
            "name" => $name,
            "slug_name" => Str::slug($name),
            "image" => null,
            "description" => "Uzun Açıklama",
            "sort_description" => "Kısa Açıklama",
//            "price" => random_int(50, 9999) . "." . random_int(1, 99),
            "size" => ["Small", "Large", "Medium"][random_int(0, 2)],
            "color" => ["Red", "Green", "Blue", "Purple"][random_int(0, 3)],
            "quantity" => rand(1, 99),
            "status" => 1
        ];
    }
}
