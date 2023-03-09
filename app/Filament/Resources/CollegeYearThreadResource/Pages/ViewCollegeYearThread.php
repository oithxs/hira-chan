<?php

namespace App\Filament\Resources\CollegeYearThreadResource\Pages;

use App\Filament\Resources\CollegeYearThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCollegeYearThread extends ViewRecord
{
    protected static string $resource = CollegeYearThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
