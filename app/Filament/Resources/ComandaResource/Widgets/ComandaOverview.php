<?php

namespace App\Filament\Resources\ComandaResource\Widgets;

use App\Models\Comanda;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;

class ComandaOverview extends BaseWidget
{
    protected function getStats(): array
    {
//        $recaudadoDia = Trend::model(Comanda::class)
//            ->between(start: now()->subHours(24), end: now())
//            ->perDay()
//            ->sum('precio.precio');
//
//        $recaudadoMes = Trend::model(Comanda::class)
//            ->between(start: now()->startOfMonth(), end: now())
//            ->perDay()
//            ->sum('precio.precio');

        $recaudadoDia = Comanda::cerrado()->today()->get()->map(function ($item) {
            return $item->comidas()->get()->sum('precio.precio');
        });

        $recaudadoMes = Comanda::cerrado()->month()->get()->map(function ($item) {
            return $item->comidas()->get()->sum('precio.precio');
        });

        return [
            Stat::make('Recaudado en el día: ', $recaudadoDia->sum()),
            Stat::make('Recaudado mensual: ', $recaudadoMes->sum()),
        ];
    }
}
