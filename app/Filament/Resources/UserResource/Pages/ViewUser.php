<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/viewing-records 多分これ
     * @todo 正確なリンクを探す．
     *
     * @var string
     */
    protected static string $resource = UserResource::class;

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/viewing-records 多分これ
     * @todo 正確なリンクを探す．
     *
     * @return array
     */
    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
