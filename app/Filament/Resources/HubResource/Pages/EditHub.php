<?php

namespace App\Filament\Resources\HubResource\Pages;

use App\Filament\Resources\HubResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHub extends EditRecord
{
    protected static string $resource = HubResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
