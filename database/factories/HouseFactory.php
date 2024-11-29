<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'address' => fake()->address(),
            'price' => fake()->numberBetween(80_000, 10_000_000),
            'bedrooms_count' => fake()->numberBetween(1, 10),
            'space' => fake()->numberBetween(15, 2_000),
            'description' => fake()->sentences(5, true),
        ];
    }
}
