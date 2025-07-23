<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExercisePlan extends Model
{
    /** @use HasFactory<\Database\Factories\ExercisePlanFactory> */
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'item_id',
        'user_id',
    ];


    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->withPivot([
                'multiplier',
                'metric',
            ]);
    }
}
