<?php

namespace App\Actions\Plantillas;

use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use Carbon\Carbon;

class ReunionAllaria implements IPlantilla
{
    public function execute(): array
    {
        Todo::create([
            'name' => 'Reunión',
            'description' => "",
            'points' => 1,
            'priority' => 1,
            'tag_id' => Tag::where('name', 'Allaria')->first()->id,
            'sub_tag_id' => SubTag::where('name', 'Reunion')->first()->id,
            'state' => 'done',
            'done_at' => Carbon::now(),
            'doing_at' => Carbon::now()->subHour(),
            'highlight' => false,
        ]);
        return ['error' => false];
    }
}
