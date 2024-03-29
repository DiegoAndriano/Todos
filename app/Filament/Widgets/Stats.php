<?php

namespace App\Filament\Widgets;

use App\Models\Todo;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;

class Stats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $donePorDia = Trend::query(Todo::owned())
            ->dateColumn('done_at')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->count()
            ->map(fn(TrendValue $value) => $value->aggregate)->toArray();

        $puntosPorDia = Trend::query(Todo::owned())
            ->dateColumn('done_at')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('points')
            ->map(fn(TrendValue $value) => $value->aggregate)->toArray();

        # Esto no se corresponde con el grafico de por dia
        $masPuntosDia = DB::table('todos')->where('state', '=', 'done')->where('user_id', auth()->user()->id)->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->done_at)->format('Y-m-d');
            })->map(function ($item) {
                return $item->sum('points');
            })->max();

        $averagePuntosPorDia = DB::table('todos')->where('state', '=', 'done')->where('user_id', auth()->user()->id)->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('Y-m-d');
            })->map(function ($item) {
                return $item->sum('points');
            })->average();

        $masPuntosEnUnMes = DB::table('todos')->where('state', '=', 'done')->where('user_id', auth()->user()->id)->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->done_at)->format('Y-m');
            })->map(function ($item) {
                return [
                    'mes' => Carbon::parse($item[0]->done_at)->format('M'),
                    'numero' => $item->sum('points'),
                ];
            })->values()->sortByDesc('numero');

        return [
            Stat::make('To do', Todo::where('state', 'to-do')->owned()->count()),
            Stat::make('Done total', Todo::where('done_at', '!=', null)->owned()->count())
                ->chart($donePorDia)
                ->color('success'),
            Stat::make('Puntos total', Todo::where('state', '=', 'done')->owned()->sum('points'))
                ->chart($puntosPorDia)
                ->color('success'),
            Stat::make('Más puntos en un día', $masPuntosDia),
            Stat::make('Promedio puntos en un día', floor($averagePuntosPorDia)),
            Stat::make("Más puntos en un mes: {$masPuntosEnUnMes->first()['mes']}", $masPuntosEnUnMes->first()['numero']),
        ];
    }
}
