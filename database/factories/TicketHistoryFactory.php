<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketHistory>
 */
class TicketHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ticket = Ticket::query()->inRandomOrder()->first();
        $employee = $ticket->employee->id;
        return [
            'ticket_id' => $ticket->id,
            'employee_id' => $employee,
            'title' => $this->faker->word(),
            'information' => $this->faker->paragraph(1),
        ];
    }
}
