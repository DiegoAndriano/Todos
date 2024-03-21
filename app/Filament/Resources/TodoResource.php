<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TodoResource\Pages;
use App\Filament\Resources\TodoResource\Widgets\TodoOverview;
use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\Model;

class TodoResource extends Resource
{
    protected static ?string $model = Todo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Section::make()->columns(2)->columnSpan(2)->schema([
                        Forms\Components\TextInput::make('id')->dehydrated(false)->disabled(),
                        Forms\Components\TextInput::make('user_id')->dehydrated(false)->disabled()->default(auth()->user()->id),
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('points')->required(),
                        Forms\Components\TextInput::make('priority')->required(),
                        Forms\Components\Checkbox::make('highlight'),
                        Forms\Components\Select::make('tag_id')
                            ->options(Tag::owned()->get()->pluck('name', 'id'))
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('sub_tag_id')
                            ->options(fn(Forms\Get $get): Collection => SubTag::owned()->where('tag_id', $get('tag_id'))->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\Select::make('state')->options([
                            'to-do' => 'To do',
                            'doing' => 'Doing',
                            'done' => 'Done',
                            'cancelado' => 'Cancelado',
                            'backlog' => 'Backlog',
                        ]),
                        Forms\Components\Select::make('parent_id')
                            ->options(Todo::owned()->get()->pluck('name', 'id'))->searchable(),
                        Select::make('shared_with')
                            ->multiple()
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => User::whereIn('id', $values)->pluck('name', 'id')->toArray()),
                        Forms\Components\TextInput::make('description'),
                        Forms\Components\TextInput::make('doing_at'),
                        Forms\Components\TextInput::make('done_at'),
                        Forms\Components\TextInput::make('highlighted_at'),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordClasses(fn(Model $record) => match ($record->state) {
                'to-do' => 'bg-red-500/15',
                'doing' => 'bg-yellow-500/15',
                'done' => 'bg-green-500/15',
                'cancelado' => 'bg-blue-500/15',
                'backlog' => 'bg-fuchsia-500/15',
            })
            ->groups([
                Group::make('parent_id')
                    ->collapsible()
                    ->groupQueryUsing(fn(Builder $query) => $query->groupBy('parent_id'))
                    ->orderQueryUsing(fn($query) => $query->orderBy("parent_id", "desc")),
            ])
            ->defaultGroup('parent_id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('priority')->sortable(query: function (Builder $query, string $direction): Builder {
                    return $query
                        ->orderByRaw("FIELD(state , 'doing', 'to-do', 'done','backlog', 'cancelado') ASC")
                        ->orderBy('priority', $direction);
                }),
                SelectColumn::make('state')->options([
                    'to-do' => 'To do',
                    'doing' => 'Doing',
                    'done' => 'Done',
                    'cancelado' => 'Cancelado',
                    'backlog' => 'Backlog',
                ])
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state == 'doing') {
                            $record->update([
                                'doing_at' => Carbon::now()
                            ]);
                        }

                        if ($state == 'done') {
                            $record->update([
                                'done_at' => Carbon::now()
                            ]);
                        }
                    }),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->limit(25),
                Tables\Columns\TextColumn::make('points')->sortable(),
                Tables\Columns\IconColumn::make('highlight')->boolean(),
                Tables\Columns\TextColumn::make('tag.name')->sortable(),
                Tables\Columns\TextColumn::make('subtag.name')->sortable(),
                TextInputColumn::make('description')->sortable(),
                Tables\Columns\TextColumn::make('parent_id')->label('Parent')->sortable(),
            ])->defaultSort('priority')
            ->filters([
                Tables\Filters\SelectFilter::make('tag')
                    ->options(Tag::owned()->get()->pluck('name', 'id'))
                    ->label('Tag')
                    ->attribute('tag_id'),
                Tables\Filters\SelectFilter::make('subtag')
                    ->label('Subtag')
                    ->options(SubTag::owned()->get()->pluck('name', 'id'))
                    ->attribute('sub_tag_id'),
                Tables\Filters\SelectFilter::make('state')
                    ->multiple()
                    ->options([
                        'to-do' => 'To do',
                        'doing' => 'Doing',
                        'done' => 'Done',
                        'cancelado' => 'Cancelado',
                        'backlog' => 'Backlog',
                    ])->default(['to-do', 'doing'])
                    ->label('State'),
                Tables\Filters\Filter::make('highlight')
                    ->label('Highlighted')
                    ->query(fn(Builder $query): Builder => $query->where('highlight', true)),
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
            'index' => Pages\ListTodos::route('/'),
            'create' => Pages\CreateTodo::route('/create'),
            'edit' => Pages\EditTodo::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            TodoOverview::class
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->ownedOrShared();
    }
}
