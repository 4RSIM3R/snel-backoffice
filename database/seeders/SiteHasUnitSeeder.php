<?php

namespace Database\Seeders;

use App\Models\SiteHasUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteHasUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteHasUnit::factory()->count(25)->create();
    }
}
