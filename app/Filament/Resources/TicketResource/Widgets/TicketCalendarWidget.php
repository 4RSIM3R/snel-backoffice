<?php

namespace App\Filament\Resources\TicketResource\Widgets;

use App\Models\Ticket;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class TicketCalendarWidget extends FullCalendarWidget
{

    public string|null|Model $model = Ticket::class;

    public function fetchEvents(array $info): array
    {
        return Ticket::where('date', '>=', $info['start'])
            ->where('date', '<=', $info['end'])
            ->get()
            ->map(function (Ticket $task) {
                return [
                    'id' => $task->id,
                    'title' => $task->number,
                    'start' => $task->date,
                    'end' => $task->date,
                ];
            })
            ->toArray();
    }

    public static function canView(): bool
    {
        return false;
    }

}
