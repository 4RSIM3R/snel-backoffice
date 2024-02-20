<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{

    public function definition(): array
    {
        return [
            'company_id' => Company::query()->inRandomOrder()->first()->id,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'phone_number' => $this->faker->numerify('+628##########'),
        ];
    }
}
