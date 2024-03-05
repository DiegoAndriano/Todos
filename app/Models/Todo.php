<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'highlight',
        'description',
        'tag',
        'parent_id',
        'state',
        'points',
        'tag_id',
        'sub_tag_id',
        'priority',
        'done_at',
        'doing_at',
    ];

    protected $casts = [
        'done_at' => 'datetime:Y-m-d H:i:s',
        'doing_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function subtag(): BelongsTo
    {
        return $this->belongsTo(SubTag::class, 'sub_tag_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Todo::class);
    }

    public function scopeOverToday(Builder $query)
    {
        $query->where('done_at', '>', Carbon::today());
    }

    public function scopeTodo(Builder $query)
    {
        $query->where('state', 'to-do');
    }

    public function scopeDone(Builder $query)
    {
        $query->where('state', 'done');
    }

    public function scopeDoing(Builder $query)
    {
        $query->where('state', 'doing');
    }

    public function scopeHighlighted(Builder $query)
    {
        $query->where('highlight', true);
    }

    public function scopeToday(Builder $query)
    {
        $query->where('created_at', '>', Carbon::today());
    }

    public function scopeAllaria(Builder $query)
    {
        $tagAllaria = Tag::where('name', 'Allaria')->first()->id;
        $query->where('tag_id', $tagAllaria);
    }

    public function scopeEmprendimiento(Builder $query)
    {
        $tagEmprendimiento = Tag::where('name', 'Emprendimiento')->first()->id;
        $query->where('tag_id', $tagEmprendimiento);
    }

    public function scopeEjercicio(Builder $query)
    {
        $tagEjercicio = Tag::where('name', 'Ejercicio')->first()->id;
        $query->where('tag_id', $tagEjercicio);
    }

    public function scopeAprendizaje(Builder $query)
    {
        $tagAprendiaje = Tag::where('name', 'Aprendizaje')->first()->id;
        $query->where('tag_id', $tagAprendiaje);

    }
}
