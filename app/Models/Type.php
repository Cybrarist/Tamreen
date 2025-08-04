<?php

namespace App\Models;

use App\Models\Scopes\OwnerOnlyScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy(OwnerOnlyScope::class)]
class Type extends Model
{
    /** @use HasFactory<\Database\Factories\TypeFactory> */
    use HasFactory;

    protected $fillable =[
        'name',
        'icon',
        'color',
        'user_id',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
