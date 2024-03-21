<?php

namespace App\Filament\Resources\SubTagResource\Pages;

use App\Filament\Resources\SubTagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubTag extends EditRecord
{
    protected static string $resource = SubTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
