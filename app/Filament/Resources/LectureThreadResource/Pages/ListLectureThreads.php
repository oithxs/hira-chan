<?php

namespace App\Filament\Resources\LectureThreadResource\Pages;

use App\Filament\Resources\LectureThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLectureThreads extends ListRecords
{
    protected static string $resource = LectureThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
