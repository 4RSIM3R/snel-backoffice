<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'customer_id' => Customer::query()->inRandomOrder()->first()->id,
            'name' => $this->faker->word,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude($min = -90, $max = 90),
            'longitude' => $this->faker->longitude($min = -180, $max = 180),
        ];
    }
}
