<?php

namespace App\Filament\Resources\ClubThreadResource\Pages;

use App\Filament\Resources\ClubThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClubThread extends EditRecord
{
    protected static string $resource = ClubThreadResource::class;

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
