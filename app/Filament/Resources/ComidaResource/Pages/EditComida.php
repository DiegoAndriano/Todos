<?php

namespace App\Filament\Resources\ComidaResource\Pages;

use App\Filament\Resources\ComidaResource;
use App\Models\Comida;
use App\Models\Precio;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditComida extends EditRecord
{
    protected static string $resource = ComidaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($record->precio !== null) {
            if ($data['precio'] !== null) {
                Comida::create([
                    'comida' => $data['comida'] ?? $record->comida,
                    'precio' => $data['precio']
                ]);

                $record->update(['visible' => false]);
            } else {
                $record->update(['comida' => $data['comida']]);
            }
        } else {
            $record->update(['precio' => $data['precio']]);
        }


        return $record;
    }
}
