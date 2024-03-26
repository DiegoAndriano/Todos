<?php

namespace App\Actions\Plantillas;

use App\Models\SubTag;
use App\Models\Tag;
use App\Models\Todo;
use Carbon\Carbon;

class PresenteEscritura implements IPlantilla
{
    public function execute(): array
    {
        Todo::create([
            'name' => 'Presente escritura',
            'description' => "",
            'points' => 1,
            'priority' => 2,
            'tag_id' => Tag::where('name', 'Misc')->first()->id,
            'sub_tag_id' => SubTag::where('name', 'Escritura')->first()->id,
            'state' => 'done',
            'done_at' => Carbon::now(),
            'doing_at' => Carbon::now()->subMinutes(30),
            'highlight' => false,
            'user_id' => auth()->user()->id,
        ]);
        return ['error' => false];
    }
}
