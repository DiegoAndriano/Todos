<?php

namespace App\Filament\Resources\TodoResource\Widgets;

use App\Models\Tag;
use App\Models\Todo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodoOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $estados = [
            '|---------|',
            '|x--------|',
            '|xx-------|',
            '|xxx------|',
            '|nice-----|',
            '|xxxxx----|',
            '|xxxxxx---|',
            '|finders--|',
            '|xxxxxxxx-|',
            '|xxxxxxxxx|',
            "Killin' it!",
            "Killin' it!",
            "Wow",
            "Wow",
            "Epico!",
            "Epico!",
            "Legen-dary",
            "Legen-dary",
        ];

        $sum = \App\Models\Todo::overToday()->owned()->sum('points');


        $estado = $estados[$sum];

        $widgets = [];
        $widgets[] = Stat::make('Dia', $estado);
        foreach(Tag::where('user_id', auth()->user()->id)->where('is_widget', true)->get() as $tag) {
            $widgets[] = Stat::make($tag->name . ' - aim: ' . $tag->aim, Todo::overToday()->where('tag_id', $tag->id)->sum('points'));
        }

        return $widgets;
    }
}
