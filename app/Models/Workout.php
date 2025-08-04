<?php

namespace App\Models;

use App\Enum\WorkoutStatusEnum;
use App\Models\Scopes\OwnerOnlyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy(OwnerOnlyScope::class)]
class Workout extends Model
{
    /** @use HasFactory<\Database\Factories\WorkoutFactory> */
    use HasFactory;

    protected $fillable =[
        'name',
        'status',
        'exercise_plan_id',
        'item_id',
        'user_id',
    ];

    protected $casts = [
        'status' =>WorkoutStatusEnum::class,
    ];


    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->withPivot([
                'multiplier',
                'metric',
                'count',
                'total',
                'completed',
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function exercise_plan(): BelongsTo
    {
        return $this->belongsTo(ExercisePlan::class);
    }
}
