<?php

namespace App\Filament\Resources\ClubThreadResource\Pages;

use App\Filament\Resources\ClubThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClubThreads extends ListRecords
{
    protected static string $resource = ClubThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
