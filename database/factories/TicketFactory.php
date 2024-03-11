<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customer::query()->whereHas('sites')->inRandomOrder()->first();
        $site = $customer->sites()->inRandomOrder()->first();
        return [
            'customer_id' => $customer->id,
            'site_id' => $site->id,
            'employee_id' => Employee::query()->inRandomOrder()->first()->id,
            'title' => $this->faker->title(),
            'information' => $this->faker->paragraph(1),
            'type' => $this->faker->randomElement(['RECORDING', 'REGULAR', 'PRIORITY']),
            'status' => $this->faker->randomElement(['NEED_ADMIN_REVIEW', 'CANCEL']),
            'date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
