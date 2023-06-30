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
            "subject" => fake()->title,
            "message" => fake()->text,
            "ip" => fake()->ipv4,
            "status" => 0
        ];
    }
}
