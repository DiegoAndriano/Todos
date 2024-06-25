<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comida extends Model
{
    use HasFactory;

    protected $fillable = [
        'comida',
        'precio_id'
    ];

    public function comandas(): BelongsToMany
    {
        return $this->belongsToMany(Comanda::class, 'comidas_comandas', 'comida_id', 'comanda_id');
    }

    public function precio(): BelongsTo
    {
        return $this->belongsTo(Precio::class);
    }
}
