<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $fillable = [
        'comida_id',
        'precio',
        'updated_at'
    ];

    public function comida()
    {
        return $this->belongsTo(Comida::class);
    }
}
