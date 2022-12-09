<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/editing-records
     *
     * @var string
     */
    protected static string $resource = UserResource::class;

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/editing-records
     *
     * @return array
     */
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
