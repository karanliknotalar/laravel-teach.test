<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => "Slider " . random_int(100, 999),
            "content" => "<p>Mağazamıza hoşgeldiniz alışverişe burdan başlaaybilirsiniz</p>",
            "image" => null,
            "shop_url" => "urunler",
            "status" => 1
        ];
    }
}
