<?php

namespace App\Filament\Resources\CollegeYearThreadResource\Pages;

use App\Filament\Resources\CollegeYearThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollegeYearThreads extends ListRecords
{
    protected static string $resource = CollegeYearThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
