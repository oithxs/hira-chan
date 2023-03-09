<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HubResource\Pages;
use App\Filament\Resources\HubResource\RelationManagers;
use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Forms\Components;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HubResource extends Resource
{
    /**
     * 対象のモデル
     *
     * @var string|null
     */
    protected static ?string $model = Hub::class;

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-collection';


    /**
     * 管理画面で作成・編集する際のフォーム
     *
     * @link https://filamentphp.com/docs/2.x/forms/fields
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('thread_secondary_category_id')
                    ->label('カテゴリ')
                    ->options(ThreadSecondaryCategory::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('ユーザEmail')
                    ->options(User::all()->pluck('email', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    /**
     * 管理画面での表示ページ
     *
     * @link https://filamentphp.com/docs/2.x/admin/resources/listing-records
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('thread_secondary_category.name')
                    ->label('カテゴリ')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('user.email')
                    ->label('ユーザEmail')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
    }

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/relation-managers
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            //HubRelationManager::class
        ];
    }

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHub::route('/'),
            'create' => Pages\CreateHub::route('/create'),
            'view' => Pages\ViewHub::route('/{record}'),
            'edit' => Pages\EditHub::route('/{record}/edit'),
        ];
    }

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
