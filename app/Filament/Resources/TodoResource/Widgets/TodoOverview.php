<?php

namespace App\Filament\Resources\TodoResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodoOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $estado = "Objetivos pendientes";
        $sum = \App\Models\Todo::overToday()
            ->allaria()
            ->sum('points') >= 4
            && \App\Models\Todo::overToday()->emprendimiento()->sum('points') >= 1
            && \App\Models\Todo::overToday()->ejercicio()->sum('points') >= 1
            && \App\Models\Todo::overToday()->aprendizaje()->sum('points') >= 3;


        if ($sum) {
            $estado = "Objetivos Alcanzados!";
        }

        return [
            Stat::make('Dia', $estado)->color('success'),
            Stat::make('Allaria (objetivo: 4)', \App\Models\Todo::overToday()->allaria()->sum('points')),
            Stat::make('Emprendimiento (objetivo: 1)', \App\Models\Todo::overToday()->emprendimiento()->sum('points')),
            Stat::make('Ejercicio (objetivo: 1)', \App\Models\Todo::overToday()->ejercicio()->sum('points')),
            Stat::make('Aprendizaje (objetivo: 3)', \App\Models\Todo::overToday()->aprendizaje()->sum('points')),
        ];
    }
}
