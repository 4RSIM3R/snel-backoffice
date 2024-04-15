<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EmployeeSeeder::class,
            ServiceSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            SiteSeeder::class,
            // TicketSeeder::class,
            InquirySeeder::class,
            // TicketHistorySeeder::class,
            SiteSeeder::class,
            UnitSeeder::class,
            SiteHasUnitSeeder::class,
        ]);
    }

}
