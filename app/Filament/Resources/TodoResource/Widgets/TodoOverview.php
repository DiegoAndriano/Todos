<?php

namespace App\Filament\Resources\TodoResource\Widgets;

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

        $sum = \App\Models\Todo::overToday()->allaria()->sum('points')
            + \App\Models\Todo::overToday()->emprendimiento()->sum('points')
            + \App\Models\Todo::overToday()->ejercicio()->sum('points')
            + \App\Models\Todo::overToday()->aprendizaje()->sum('points');


        $estado = $estados[$sum];

        return [
            Stat::make('Dia', $estado),
            Stat::make('Allaria (objetivo: 4)', \App\Models\Todo::overToday()->allaria()->sum('points')),
            Stat::make('Emprendimiento (objetivo: 1)', \App\Models\Todo::overToday()->emprendimiento()->sum('points')),
            Stat::make('Ejercicio (objetivo: 1)', \App\Models\Todo::overToday()->ejercicio()->sum('points')),
            Stat::make('Aprendizaje (objetivo: 3)', \App\Models\Todo::overToday()->aprendizaje()->sum('points')),
        ];
    }
}
