<?php

namespace Database\Factories;

use App\Models\Site;
use App\Models\SiteHasUnit;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteHasUnit>
 */
class SiteHasUnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $site = Site::query()->whereHas('customer')->inRandomOrder()->first();
        $customer = $site->customer()->first(); // Ensures customer is loaded correctly.
        $unit = Unit::query()->inRandomOrder()->first();

        return [
            'site_id' => $site->id,
            'customer_id' => $customer->id, // Now correctly accessing the customer's ID.
            'unit_id' => $unit->id,
        ];
    }
}
