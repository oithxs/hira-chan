<?php

namespace App\Filament\Resources\CollegeYearThreadResource\Pages;

use App\Filament\Resources\CollegeYearThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollegeYearThread extends EditRecord
{
    protected static string $resource = CollegeYearThreadResource::class;

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
