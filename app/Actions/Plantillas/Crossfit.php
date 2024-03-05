<?php

namespace App\Actions\Plantillas;

use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use Carbon\Carbon;

class Crossfit implements IPlantilla {

    public function execute(): array
    {
        Todo::create([
            'name' => 'Crossfit',
            'description' => "",
            'points' => 2,
            'priority' => 1,
            'tag_id' => Tag::where('name', 'Ejercicio')->first()->id,
            'sub_tag_id' => SubTag::where('name', 'Crossfit')->first()->id,
            'state' => 'done',
            'done_at' => Carbon::createFromTime('11', '00', '00'),
            'doing_at' => Carbon::createFromTime('12', '00', '00'),
            'highlight' => false,
        ]);
        return ['error' => false];
    }
}
