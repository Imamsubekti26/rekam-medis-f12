<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->lastName(),
            'description' => fake()->sentence(4),
            'stock' => fake()->numberBetween(10, 99),
            'price' => fake()->numberBetween(2000, 10000),
            'barcode' => fake()->ean13()
        ];
    }
}
