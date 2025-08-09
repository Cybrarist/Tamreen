<?php

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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit')->default(\App\Enum\ExerciseUnitEnum::Reps->value);
            $table->text('images')->default("[]");
            $table->text('videos')->default("[]");

            $table->foreignIdFor(User::class)->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
