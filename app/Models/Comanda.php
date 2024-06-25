<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comanda extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'mesa'
    ];

    public function comidas(): BelongsToMany
    {
        return $this->belongsToMany(Comida::class, 'comidas_comandas', 'comanda_id', 'comida_id');
    }

    public function scopeToday(Builder $query)
    {
        $query->whereDate('created_at', '=', Carbon::today());
    }

    public function scopeCerrado(Builder $query)
    {
        $query->where('estado', 'cerrado');
    }

    public function scopeMonth(Builder $query)
    {
        $query
            ->where('created_at', '>=', Carbon::today()->subDays(Carbon::now()->day - 1));
    }
}
