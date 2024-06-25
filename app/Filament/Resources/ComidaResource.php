<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComidaResource\Pages;
use App\Filament\Resources\ComidaResource\RelationManagers;
use App\Models\Comida;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComidaResource extends Resource
{
    protected static ?string $model = Comida::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('comida'),
                Forms\Components\TextInput::make('precio')->afterStateHydrated(
                    function ($record, TextInput $component,$state) {
                        if($record != null){
                            $component->state($record->precio()->first() ? $record->precio()->first()->precio : 0);
                        }
                    }
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('comida')->sortable()->searchable()->limit(25),
                Tables\Columns\TextColumn::make('precio.precio')->sortable()->searchable()->limit(25)->prefix('$'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListComidas::route('/'),
            'create' => Pages\CreateComida::route('/create'),
            'edit' => Pages\EditComida::route('/{record}/edit'),
        ];
    }
}
