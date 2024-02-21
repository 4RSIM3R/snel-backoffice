<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

    protected static ?string $title = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data["password"] = Hash::make($data["password"]);
        return $data;
    }

}
