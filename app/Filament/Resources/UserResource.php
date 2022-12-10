<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\UserPageTheme;
use Filament\Forms;
use Filament\Resources\Forms\Components;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    /**
     * 対象のモデル
     *
     * @var string|null
     */
    protected static ?string $model = User::class;

    /**
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    /**
     * 管理画面で作成・編集する際のフォーム
     *
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_page_theme_id')
                    ->label('ページテーマ')
                    ->options(UserPageTheme::all()->pluck('theme_name', 'id'))
                    ->searchable()
                    ->default(1),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
                Forms\Components\DateTimePicker::make('email_verified_at')->displayFormat('Y-m-d H:i:s'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
            ]);
    }

    /**
     * 管理画面での表示ページ
     *
     * @link https://filamentphp.com/docs/2.x/admin/resources/getting-started
     * @link https://readouble.com/laravel/9.x/ja/migrations.html
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\IconColumn::make('email_verified_at')
                    ->label('verified')
                    ->boolean()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
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
