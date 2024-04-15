<?php

namespace Database\Factories;

use App\Models\Company;
use App\Traits\StringTrait;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
class CompanyFactory extends Factory
{

    use StringTrait;

    public function definition(): array
    {
        $name = $this->faker->company;
        $alias = $this->companyAlias($name);

        return [
            'name' => $name,
            'business_name' => $alias,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude($min = -90, $max = 90),
            'longitude' => $this->faker->longitude($min = -180, $max = 180),
        ];
    }

    public function company()
    {

        return $this->state(function () {

            $name = $this->faker->company;
            $alias = $this->companyAlias($name);

            return [
                'name' => $name,
                'business_name' => $alias,
                'address' => $this->faker->address,
                'latitude' => $this->faker->latitude($min = -90, $max = 90),
                'longitude' => $this->faker->longitude($min = -180, $max = 180),
            ];
        });

    }

}
