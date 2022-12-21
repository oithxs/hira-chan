<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobHuntingThreadResource\Pages;
use App\Filament\Resources\JobHuntingThreadResource\RelationManagers;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobHuntingThreadResource extends Resource
{
    /**
     * 対象のモデル
     *
     * @var string|null
     */
    protected static ?string $model = JobHuntingThread::class;

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    /**
     * 項目のグループ化
     *
     * @link https://filamentphp.com/docs/2.x/admin/navigation#grouping-navigation-items
     *
     * @var string|null
     */
    protected static ?string $navigationGroup = 'Posts';

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
                Forms\Components\Select::make('hub_id')
                    ->label('スレッドID')
                    ->options(Hub::all()->pluck('id', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label('ユーザEmail')
                    ->options(User::all()->pluck('email', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('message_id')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->required(),
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
                Tables\Columns\TextColumn::make('hub.id')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('user.email')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('message_id')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('message')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable(isIndividual: true)
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
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
            'index' => Pages\ListJobHuntingThreads::route('/'),
            'create' => Pages\CreateJobHuntingThread::route('/create'),
            'view' => Pages\ViewJobHuntingThread::route('/{record}'),
            'edit' => Pages\EditJobHuntingThread::route('/{record}/edit'),
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
