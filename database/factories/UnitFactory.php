<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identifier' => $this->faker->buildingNumber(),
            'name' => $this->faker->domainName(),
            'description' => $this->faker->paragraph(5),
            'specification' => $this->faker->paragraph(),
        ];
    }
}
