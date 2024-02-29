<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Site;
use App\Tables\Columns\CoordinateColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Client";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->required()->columnSpan(2),
                        Textarea::make('address')->required()->columnSpan(2),
                        TextInput::make('latitude')->numeric()->required(),
                        TextInput::make('longitude')->numeric()->required(),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship(name: 'company', titleAttribute: 'name')
                            ->preload()
                            ->searchable()
                            ->live()
                            ->required(),
                        Select::make('customer_id')
                            ->label('PIC')
                            ->options(fn(Forms\Get $get): Collection => Customer::query()
                                ->where('company_id', '=', $get('company_id'))
                                ->pluck('name', 'id')
                            )
                            ->live()
                            ->searchable()
                            ->required(),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->rowIndex(),
                TextColumn::make('name')->wrap(),
                TextColumn::make('company.name')->label('Company')->url(fn(Customer $r): string => url('/admin/companies/' . $r->company_id))->wrap(),
                TextColumn::make('customer.name')->label('PIC')->url(fn(Customer $r): string => url('/admin/customer/' . $r->customer_id))->wrap(),
                TextColumn::make('address')->wrap(),
                CoordinateColumn::make('Location')
            ])
            ->filters([

            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}
