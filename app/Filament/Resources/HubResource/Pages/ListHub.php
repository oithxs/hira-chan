<?php

namespace App\Filament\Resources\HubResource\Pages;

use App\Filament\Resources\HubResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHub extends ListRecords
{
    protected static string $resource = HubResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
