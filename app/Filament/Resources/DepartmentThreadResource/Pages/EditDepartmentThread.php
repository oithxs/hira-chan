<?php

namespace App\Filament\Resources\DepartmentThreadResource\Pages;

use App\Filament\Resources\DepartmentThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartmentThread extends EditRecord
{
    protected static string $resource = DepartmentThreadResource::class;

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
