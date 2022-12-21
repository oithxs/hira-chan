<?php

namespace App\Filament\Resources\DepartmentThreadResource\Pages;

use App\Filament\Resources\DepartmentThreadResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartmentThreads extends ListRecords
{
    protected static string $resource = DepartmentThreadResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
