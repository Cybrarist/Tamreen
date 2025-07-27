<?php

namespace App\Models;

use App\Models\Scopes\OwnerOnlyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy(OwnerOnlyScope::class)]
class ExercisePlanTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\ExercisePlanTemplateFactory> */
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'user_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->withPivot(['multiplier']);
    }
}
