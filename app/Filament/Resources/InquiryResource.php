<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Models\Inquiry;
use App\Utils\StyleUtils;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ticketing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('status')
                    ->color(fn($state) => StyleUtils::getStatusColor(strtolower($state)))
                    ->extraAttributes(['text-sm'])
                    ->formatStateUsing(fn($state) => ucwords(str_replace('_', ' ', strtolower($state))))
                    ->wrap(),
                TextColumn::make('customer.name')->wrap(),
                TextColumn::make('site.name')
                    ->description(fn (Inquiry $inquiry) => $inquiry->site()->first()->address)
                    ->wrap(),
                TextColumn::make('title')->wrap(),

            ])
            ->filters([
                //
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
            'index' => Pages\ListInquiries::route('/'),
            'view' => Pages\ViewInquiry::route('/{record}'),
        ];
    }
}
