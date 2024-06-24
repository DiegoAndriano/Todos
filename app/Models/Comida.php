<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comida extends Model
{
    use HasFactory;

    protected $fillable = [
        'comida',
        'precio'
    ];

    public function comandas(): BelongsToMany
    {
        return $this->belongsToMany(Comanda::class, 'comidas_comandas', 'comida_id', 'comanda_id');
    }
}
