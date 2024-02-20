<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->domainName();
        return [
            'name' => $name,
            'description' => $this->faker->paragraph(),
            'code' => Str::slug($name),
            'price' => $this->faker->numberBetween(0, 100_000)
        ];
    }
}
