<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubTag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tag_id'];


    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function todo(): HasMany
    {
        return $this->hasMany(Todo::class);
    }

    public function scopeOwned(Builder $query)
    {
        $query->with('tag')->whereHas('tag', fn($query) => $query->where('user_id', auth()->user()->id));
    }

}
