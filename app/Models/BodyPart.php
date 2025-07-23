<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BodyPart extends Model
{
    /** @use HasFactory<\Database\Factories\BodyPartFactory> */
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'image',
        'user_id',
    ];


    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
