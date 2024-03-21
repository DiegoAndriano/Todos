<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'objetivo', 'is_widget'];

    public function todo(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function scopeOwned(Builder $query)
    {
        $query->where('user_id', auth()->user()->id);
    }

}
