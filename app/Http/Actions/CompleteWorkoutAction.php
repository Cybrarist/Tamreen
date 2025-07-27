<?php

namespace App\Http\Actions;

use App\Enum\WorkoutStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompleteWorkoutAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Workout $workout)
    {

        DB::transaction(function () use ($workout) {

            $workout->update([
                'status' => WorkoutStatusEnum::Completed,
            ]);

            DB::table('exercise_workout')
                ->where('workout_id', $workout->id)
                ->update(['completed' => DB::raw('total')]);

        });

    }
}
