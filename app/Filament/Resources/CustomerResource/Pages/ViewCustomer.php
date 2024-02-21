<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\CustomerResource\RelationManagers\CustomerSitesRelation;
use App\Tables\Columns\CoordinateColumn;
use App\Utils\ColumnUtils;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{

    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name'),
        ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Customer Data')->schema([
                TextEntry::make('name'),
                TextEntry::make('email'),
                TextEntry::make('phone_number')->url(fn($state): string => ColumnUtils::whatsapp($state)),
                TextEntry::make('created_at'),
            ])->columns(2),
            Section::make('Company Data')->schema([
                TextEntry::make('company.name')->name('Name'),
                TextEntry::make('company.business_name')->name('Alias'),
                TextEntry::make('company.address')->name('Address'),

            ])->columns(2),
        ]);
    }

    public function getRelationManagers(): array
    {
        return [
            CustomerSitesRelation::class,
        ];
    }

}
