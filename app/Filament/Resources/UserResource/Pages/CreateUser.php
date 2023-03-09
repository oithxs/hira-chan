<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/creating-records
     *
     * @var string
     */
    protected static string $resource = UserResource::class;
}
