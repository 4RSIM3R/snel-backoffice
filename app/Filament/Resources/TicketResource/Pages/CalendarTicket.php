<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class CalendarTicket extends Page
{

    protected static string $resource = TicketResource::class;

    protected static ?string $title = "Calendar";

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    protected static string $view = 'filament.resources.ticket-resource.pages.calendar-ticket';

    protected static bool $shouldRegisterNavigation = false;

}
