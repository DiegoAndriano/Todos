<?php

namespace App\Filament\Widgets;

use App\Models\Todo;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PuntosDoneWeeklyChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::model(Todo::class)
        ->dateColumn('done_at')
        ->between(
            start: now()->startOfYear(),
            end: now()->endOfYear(),
        )
        ->perMonth()
        ->count();

        return [
            'datasets' => [
            [
                'label' => 'Todos completados',
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
        return 'bar';
    }
}
