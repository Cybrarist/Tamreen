<?php

namespace App\Models;

use App\Enum\ExerciseUnitEnum;
use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ScopedBy(UserScope::class)]
class Exercise extends Model
{
    /** @use HasFactory<\Database\Factories\ExerciseFactory> */
    use HasFactory;


    protected $fillable= [
        'name',
        'description',
        'images',
        'videos',
        'unit',
        'body_part_id',
        'user_id',
    ];


    protected function casts(): array
    {
        return [
            'videos' => 'array',
            'images' => 'array',
            'unit' => ExerciseUnitEnum::class,
        ];
    }


    public function body_parts(): BelongsToMany
    {
        return $this->belongsToMany(BodyPart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
