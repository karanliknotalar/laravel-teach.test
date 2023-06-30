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
            "slug" => Str::slug($name),
            "image" => null,
            "description" => "Uzun Açıklama",
            "sort_description" => "Kısa Açıklama",
            "status" => 1
        ];
    }
}
