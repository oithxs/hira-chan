<?php

namespace App\Filament\Resources\LectureThreadResource\Pages;

use App\Filament\Resources\LectureThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLectureThread extends ViewRecord
{
    protected static string $resource = LectureThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
