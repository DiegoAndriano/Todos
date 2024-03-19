<?php

namespace App\Filament\Widgets;

use App\Models\Todo;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PuntosDoneDailyChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Puntos por dia (dia 0 es el 15 de febrero)';

    protected function getData(): array
    {
        $data = Trend::query(Todo::owned())
        ->dateColumn('done_at')
        ->between(
            start: now()->subMonths(1),
            end: now()->addMonths(1),
        )
        ->perDay()
        ->sum('points');

        return [
            'datasets' => [
            [
                'label' => 'Puntos por día',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                'backgroundColor' => '#36A2EB',
                'borderColor' => '#9BD0F5',
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

