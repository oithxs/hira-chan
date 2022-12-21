<?php

namespace App\Filament\Resources\LectureThreadResource\Pages;

use App\Filament\Resources\LectureThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLectureThread extends EditRecord
{
    protected static string $resource = LectureThreadResource::class;

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
