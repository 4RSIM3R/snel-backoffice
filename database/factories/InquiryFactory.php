<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inquiry>
 */
class InquiryFactory extends Factory
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
            'title' => $this->faker->title(),
            'information' => $this->faker->paragraph(1),
            'status' => $this->faker->randomElement(['NEED_REVIEW', 'DISMISS']),
        ];
    }
}
