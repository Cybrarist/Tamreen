<?php

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exercise_workout', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->foreignIdFor(Exercise::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Workout::class)->constrained()->cascadeOnDelete();
            $table->decimal('multiplier');
            $table->string('metric')->nullable();
            $table->unsignedInteger('count')->default(0);
            $table->unsignedInteger('total')->default(0);
            $table->unsignedInteger('completed')->default(0);

            $table->unique(['exercise_id', 'workout_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_workouts');
    }
};
