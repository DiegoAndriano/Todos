<?php

namespace App\Models;

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
}
