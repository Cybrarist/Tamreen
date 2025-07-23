<?php

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

            $table->unsignedInteger('multiplier')->default(1);
            $table->foreignIdFor(App\Models\Exercise::class)->constrained();
            $table->foreignIdFor(App\Models\ExercisePlan::class)->constrained();


            $table->unique(['exercise_id', 'exercise_plan_id', 'metric']);
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
