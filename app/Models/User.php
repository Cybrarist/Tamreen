<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enum\UserRoleEnum;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => userRoleEnum::class,
        ];
    }


    public function body_parts(): HasMany
    {
        return $this->hasMany(BodyPart::class);
    }

    public function exercise_plan_templates(): HasMany
    {
        return $this->hasMany(ExercisePlanTemplate::class);
    }
    public function exercise_plans(): HasMany
    {
        return $this->hasMany(ExercisePlan::class);
    }
    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }
}
