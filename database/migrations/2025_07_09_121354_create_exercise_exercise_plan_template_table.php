<?php

use App\Models\Exercise;
use App\Models\ExercisePlanTemplate;
use App\Models\User;
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
        Schema::create('exercise_exercise_plan_template', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Exercise::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ExercisePlanTemplate::class)->constrained()->cascadeOnUpdate();

            $table->unsignedInteger('multiplier')->default(1);
            $table->unique(['exercise_id', 'exercise_plan_template_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_exercise_plan_template');
    }
};
