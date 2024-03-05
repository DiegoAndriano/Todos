<?php

namespace App\Filament\Resources\TodoResource\Pages;

use App\Filament\Resources\TodoResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ListTodos extends ListRecords
{
    protected static string $resource = TodoResource::class;

    protected function getHeaderActions(): array
    {
        $files = array_filter(File::allFiles(app_path('Actions/Plantillas')), function ($item) {
            return 'IPlantilla.php' !== $item->getFileName();
        });
        return [
            Action::make('Crear de plantilla')
                ->action(function (array $data) use ($files): void {
                    redirect()->route('create.plantilla.todos', [
                        'plantilla' => collect(
                            $files
                        )->map(function ($item) {
                            return ['name' => $item->getRelativePathname()];
                        })->flatten()[$data['plantilla']],
                    ]);
                })
                ->form(
                    [
                        Select::make('plantilla')->options(collect(
                           $files
                        )->map(function ($item) {
                            return ['name' => $item->getRelativePathname()];
                        })->flatten()
                        ),
                    ]),
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TodoResource\Widgets\TodoOverview::class
        ];
    }
}
