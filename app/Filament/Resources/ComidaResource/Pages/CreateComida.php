<?php

namespace App\Filament\Resources\ComidaResource\Pages;

use App\Filament\Resources\ComidaResource;
use App\Models\Precio;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateComida extends CreateRecord
{
    protected static string $resource = ComidaResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record =  static::getModel()::create(['comida' => $data['comida']]);
        $p = Precio::create(['precio' => $data['precio'], 'comida_id' => $record->id]);
        $record->update(['precio_id' => $p->id]);

        return $record;
    }
}
