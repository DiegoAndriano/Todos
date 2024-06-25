<?php

namespace App\Filament\Resources\ComidaResource\Pages;

use App\Filament\Resources\ComidaResource;
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
        if ($record->precio()->first() !== null) {
            if ($data['precio'] !== null) {
                if ($data['precio'] != $record->precio()->first()->precio) {
                    $record->precio()->first()->update(['updated_at' => Carbon::now()]);
                    $p = Precio::create(['precio' => $data['precio'], 'comida_id' => $record->id]);
                    $record->update(['precio_id' => $p->id, 'comida' => $data['comida']]);
                } else {
                    $record->update(['comida' => $data['comida']]);
                }
            } else {
                $record->update(['comida' => $data['comida']]);
            }
        } else {
            if ($data['precio'] !== null) {
                $p = Precio::create(['precio' => $data['precio'], 'comida_id' => $record->id]);
                $record->update(['precio_id' => $p->id, 'comida' => $data['comida']]);
                $record->update(['comida' => $data['comida']]);

            } else {
                $record->update(['comida' => $data['comida']]);
            }
        }


        return $record;
    }
}
