<?php

namespace App\Filament\Resources\HubResource\Pages;

use App\Filament\Resources\HubResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewHub extends ViewRecord
{
    protected static string $resource = HubResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
