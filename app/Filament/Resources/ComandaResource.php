<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComandaResource\Pages;
use App\Filament\Resources\ComandaResource\RelationManagers;
use App\Filament\Resources\ComandaResource\Widgets\ComandaOverview;
use App\Models\Comanda;
use App\Models\Comida;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComandaResource extends Resource
{
    protected static ?string $model = Comanda::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('mesa')->required(),
                Forms\Components\Select::make('estado')->options([
                    'abierto' => 'Abierto',
                    'cerrado' => 'Cerrado',
                    'cancelado' => 'Cancelado',
                ])
                    ->live()
                    ->default('abierto'),
                Forms\Components\Select::make('comida_id')
                    ->relationship('comidas')
                    ->hidden(fn(Forms\Get $get, $record): bool => $get('estado') == 'Abierto')
                    ->multiple()
                    ->searchable()
                    ->options(Comida::where('visible', true)->get()->pluck('comida', 'id')->toArray())
                    ->getSearchResultsUsing((fn(string $search): array => Comida::where('visible', true)->where('comida', 'like', "%{$search}%")->limit(50)->pluck('comida', 'id')->toArray()))
                    ->getOptionLabelsUsing(fn(array $values): array => Comida::where('visible', true)->whereIn('id', $values)->pluck('comida', 'id')->toArray()),
                Forms\Components\Select::make('comida_id')
                    ->relationship('comidas')
                    ->label('Comidas de esta orden')
                    ->disabled()
                    ->multiple()
                    ->searchable()
                    ->options(fn($record): array => $record->comidas()->get()->pluck('comida', 'id')->toArray())
                    ->getSearchResultsUsing((fn(string $search, $record): array =>  $record->comidas()->where('comida', 'like', "%{$search}%")->limit(50)->pluck('comida', 'id')->toArray()))
                    ->getOptionLabelsUsing(fn(array $values, $record): array => $record->comidas()->whereIn('id', $values)->pluck('comida', 'id')->toArray()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mesa')->sortable()->searchable()->limit(25),
                Tables\Columns\TextColumn::make('a_cobrar')
                    ->default(fn($record) => $record->comidas()->get()->sum('precio'))
                    ->prefix('$')
                    ->visibleFrom('md'),
                SelectColumn::make('estado')->options([
                    'abierto' => 'Abierto',
                    'cerrado' => 'Cerrado',
                    'cancelado' => 'Cancelado',
                ])
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('estado')
                    ->multiple()
                    ->options([
                        'abierto' => 'Abierto',
                        'cerrado' => 'Cerrado',
                        'cancelado' => 'Cancelado',
                    ])->default(['abierto'])
                    ->label('Estado')
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
            'index' => Pages\ListComandas::route('/'),
            'create' => Pages\CreateComanda::route('/create'),
            'edit' => Pages\EditComanda::route('/{record}/edit'),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            ComandaOverview::class
        ];
    }
}
