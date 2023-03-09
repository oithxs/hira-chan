<?php

namespace App\Filament\Resources\JobHuntingThreadResource\Pages;

use App\Filament\Resources\JobHuntingThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobHuntingThread extends ViewRecord
{
    protected static string $resource = JobHuntingThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
