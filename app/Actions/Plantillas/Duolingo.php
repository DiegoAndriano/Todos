<?php

namespace App\Actions\Plantillas;

use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use Carbon\Carbon;

class Duolingo implements IPlantilla
{
    public function execute(): array
    {
        Todo::create([
            'name' => 'Griego',
            'description' => "",
            'points' => 1,
            'priority' => 1,
            'tag_id' => Tag::where('name', 'Aprendizaje')->first()->id,
            'sub_tag_id' => SubTag::where('name', 'Duolingo')->first()->id,
            'state' => 'done',
            'done_at' => Carbon::now(),
            'doing_at' => Carbon::now()->subMinutes(15),
            'highlight' => false,
        ]);
        return ['error' => false];
    }
}
