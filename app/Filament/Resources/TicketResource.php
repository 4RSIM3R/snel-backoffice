<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Customer;
use App\Models\Site;
use App\Models\Ticket;
use App\Tables\Columns\StatusColumn;
use App\Utils\StyleUtils;
use Carbon\Carbon;
use Exception;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Rawilk\FilamentQuill\Filament\Forms\Components\QuillEditor;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Ticketing";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('type')->options(Ticket::mapType),
                    Select::make('status')->options(Ticket::mapStatus)->default('ADMIN_APPROVED'),
                    TextInput::make('title')->required(),
                    QuillEditor::make('information')->required(),
                    Select::make('customer_id')->label('Customer')
                        ->relationship(name: 'customer', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query) => $query->whereHas('sites'))
                        ->preload()->searchable()->live()
                        ->disabledOn('edit')
                        ->required(),
                    Select::make('site_id')->label('Site')
                        ->options(fn(Forms\Get $get): Collection => Site::query()
                            ->where('customer_id', '=', $get('customer_id'))
                            ->pluck('name', 'id'))
                        ->live()
                        ->searchable()
                        ->required()
                        ->disabledOn('edit'),
                    Select::make('employee_id')
                        ->label('Employee')
                        ->relationship(name: 'employee', titleAttribute: 'name')
                        ->preload()
                        ->searchable()
                        ->live()
                        ->required(),
                    DatePicker::make('date')
                        ->required(),
                    SpatieMediaLibraryFileUpload::make('ticket_image')
                        ->multiple()
                        ->required()
                ])
            ]);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->wrap(),
                TextColumn::make('type')->wrap(),
                TextColumn::make('status')
                    ->color(fn($state) => StyleUtils::getStatusColor(strtolower($state)))
                    ->extraAttributes(['text-sm'])
                    ->formatStateUsing(fn($state) => ucwords(str_replace('_', ' ', strtolower($state))))
                    ->wrap(),
                TextColumn::make('customer.name')->wrap(),
                TextColumn::make('site.name')->description(fn(Ticket $ticket) => $ticket->site()->first()->address)->wrap(),
                TextColumn::make('employee.name')->wrap(),
                TextColumn::make('updated_at')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d F Y'))
                    ->label('Last Update')
                    ->wrap(),
                TextColumn::make('date')
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d F Y'))
                    ->label('Date')
                    ->wrap()
            ])
            ->filters([
                SelectFilter::make('status')->options(array_flip(Ticket::mapStatus)),
                SelectFilter::make('type')->options(array_flip(Ticket::mapType)),
                SelectFilter::make('customer')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('employee')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('site')
                    ->relationship('site', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            TicketResource\RelationManagers\HistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'calendar' => Pages\CalendarTicket::route('/calendar'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
