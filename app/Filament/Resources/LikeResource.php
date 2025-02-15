<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LikeResource\Pages;
use App\Filament\Resources\LikeResource\RelationManagers;
use App\Models\Like;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('liked_user_id')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('User') // Custom label
                ->sortable(), // Allow sorting by user name
            Tables\Columns\TextColumn::make('likedUser.name')
                ->label('Liked User') // Custom label
                ->sortable(), // Allow sorting by liked user name
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])        
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'view' => Pages\ViewLike::route('/{record}'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }
}
