<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'phone_number' => $this->faker->numerify('+628##########'),
        ];
    }

    public function employee()
    {
        return $this->state(function () {
            return [
                'name' => $this->faker->name,
                'email' => 'employee@nexteam.id',
                'password' => Hash::make('password'),
                'phone_number' => $this->faker->numerify('+628##########'),
            ];
        });
    }

}
