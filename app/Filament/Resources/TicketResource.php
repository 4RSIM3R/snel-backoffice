<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use App\Tables\Columns\StatusColumn;
use App\Utils\StyleUtils;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ticketing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->wrap(),
                TextColumn::make('status')
                    ->color(fn($state) => StyleUtils::getStatusColor(strtolower($state)))
                    ->extraAttributes(['text-sm'])
                    ->formatStateUsing(fn($state) => ucwords(str_replace('_', ' ', strtolower($state))))
                    ->wrap(),
                TextColumn::make('customer.name')->wrap(),
                TextColumn::make('site.name')->description(fn(Ticket $ticket) => $ticket->site()->first()->address)->wrap(),
                TextColumn::make('employee.name')->wrap(),
                TextColumn::make('created_at')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d F Y'))
                    ->label('Created At')
                    ->wrap()
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }
}
