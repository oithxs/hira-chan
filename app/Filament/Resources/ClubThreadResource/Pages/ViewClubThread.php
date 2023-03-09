<?php

namespace App\Filament\Resources\ClubThreadResource\Pages;

use App\Filament\Resources\ClubThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewClubThread extends ViewRecord
{
    protected static string $resource = ClubThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
