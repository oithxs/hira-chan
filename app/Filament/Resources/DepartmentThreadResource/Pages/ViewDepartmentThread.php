<?php

namespace App\Filament\Resources\DepartmentThreadResource\Pages;

use App\Filament\Resources\DepartmentThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDepartmentThread extends ViewRecord
{
    protected static string $resource = DepartmentThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
