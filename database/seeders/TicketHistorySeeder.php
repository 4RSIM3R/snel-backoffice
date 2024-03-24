<?php

namespace Database\Seeders;

use App\Models\TicketHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketHistory::factory()->count(50)->create();
    }
}
