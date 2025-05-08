<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'species' => fake()->word(),
            'is_predator' => fake()->boolean(),
            'born_at' => fake()->dateTimeBetween('-5 year', '0 year'),
            'image' => null,
            'enclosure_id' => null,
        ];
    }
}
