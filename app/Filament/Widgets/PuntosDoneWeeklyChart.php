<?php

namespace App\Filament\Widgets;

use App\Models\Todo;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PuntosDoneWeeklyChart extends ChartWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Puntos por mes';

    protected function getData(): array
    {
        $data = Trend::model(Todo::class)
            ->dateColumn('done_at')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('points');

        return [
            'datasets' => [
                [
                    'label' => 'Puntos por mes',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
