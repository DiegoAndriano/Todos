<?php

namespace App\Filament\Resources\TodoResource\Pages;

use App\Filament\Resources\TodoResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTodo extends EditRecord
{
    protected static string $resource = TodoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['state'] == 'done' && $this->record->done_at == null) {
            $data['done_at'] = Carbon::now();
        }

        if ($data['state'] == 'doing' && $this->record->doing_at == null) {
            $data['doing_at'] = Carbon::now();
        }

        if($data['highlight']){
            $data['highlighted_at'] = Carbon::now();
        }

        return $data;
    }
}
