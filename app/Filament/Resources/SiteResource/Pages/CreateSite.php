<?php

namespace App\Filament\Resources\SiteResource\Pages;

use App\Filament\Resources\SiteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateSite extends CreateRecord
{
    protected static string $resource = SiteResource::class;

    protected static bool $canCreateAnother = false;

}
