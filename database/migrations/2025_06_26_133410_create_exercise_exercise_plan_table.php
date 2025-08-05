<?php

use App\Models\Exercise;
use App\Models\ExercisePlan;
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
        Schema::create('exercise_exercise_plan', function (Blueprint $table) {
            $table->id();

            $table->string('metric')->nullable();

            $table->decimal('multiplier')->default(1);
            $table->foreignIdFor(Exercise::class)->constrained();
            $table->foreignIdFor(ExercisePlan::class, 'plan_id')->constrained();


            $table->unique(['exercise_id', 'plan_id', 'metric']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_exercise_plan');
    }
};
