<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            "name" => $name,
            "parent_id" => null,
            "slug_name" => Str::slug($name),
            "description" => Str::substr(fake()->paragraph, 0, 255),
            "seo_description" => Str::substr(fake()->paragraph, 0, 255),
            "seo_keywords" => Str::slug(Str::substr(fake()->paragraph, 0, 100), ","),
            "status" => fake()->boolean,
            "image" => fake()->imageUrl,
            "thumbnail" => fake()->imageUrl,
            "order" => random_int(1, 10),
        ];
    }
}
