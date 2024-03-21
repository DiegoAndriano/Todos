<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubTagResource\Pages;
use App\Filament\Resources\SubTagResource\RelationManagers;
use App\Models\SubTag;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubTagResource extends Resource
{
    protected static ?string $model = SubTag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'System';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Section::make()->columns(2)->columnSpan(2)->schema([
                        Forms\Components\TextInput::make('id')->dehydrated(false)->disabled(),
                        Forms\Components\TextInput::make('name'),
                        Forms\Components\Select::make('tag_id')
                            ->options(Tag::owned()->get()->pluck('name', 'id'))
                            ->required(),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->limit(25),
                Tables\Columns\TextColumn::make('tag.name')->sortable(),
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
            'index' => Pages\ListSubTags::route('/'),
            'create' => Pages\CreateSubTag::route('/create'),
            'edit' => Pages\EditSubTag::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->owned();
    }
}
