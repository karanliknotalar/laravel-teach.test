<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "firstname" => fake()->firstName,
            "lastname" => fake()->lastName,
            "email" => fake()->email,
            "subject" => "Acil Bir Durum var! " . random_int(11111,99999),
            "message" => fake()->text . fake()->text . fake()->text . fake()->text,
            "ip" => fake()->ipv4,
            "status" => 0
        ];
    }
}
