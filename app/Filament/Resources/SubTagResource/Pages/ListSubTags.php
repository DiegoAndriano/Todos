<?php

namespace App\Filament\Resources\SubTagResource\Pages;

use App\Filament\Resources\SubTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubTags extends ListRecords
{
    protected static string $resource = SubTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
