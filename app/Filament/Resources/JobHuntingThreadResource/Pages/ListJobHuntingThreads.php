<?php

namespace App\Filament\Resources\JobHuntingThreadResource\Pages;

use App\Filament\Resources\JobHuntingThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobHuntingThreads extends ListRecords
{
    protected static string $resource = JobHuntingThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
