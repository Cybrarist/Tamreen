<?php

use App\Models\BodyPart;
use App\Models\Exercise;
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
        Schema::create('body_part_exercise', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BodyPart::class)->constrained();
            $table->foreignIdFor(Exercise::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_part_exercise');
    }
};
