<?php

namespace App\Filament\Resources\JobHuntingThreadResource\Pages;

use App\Filament\Resources\JobHuntingThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobHuntingThread extends EditRecord
{
    protected static string $resource = JobHuntingThreadResource::class;

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
