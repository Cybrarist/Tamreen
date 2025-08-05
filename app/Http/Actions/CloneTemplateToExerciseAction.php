<?php

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Models\ExercisePlan;
use App\Models\ExercisePlanTemplate;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CloneTemplateToExerciseAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ExercisePlanTemplate $template, Item $item)
    {

        DB::transaction(function () use ($template, $item) {
            $plan = ExercisePlan::create([
                'name' => $template->name,
                'description' => $template->description,
                'exercise_plan_template_id' => $template->id,
                'item_id' => $item->id,
                'user_id' => Auth::id()
            ]);

            $template_exercises = DB::table('exercise_exercise_plan_template')
                ->where('template_id', $template->id)
                ->pluck('multiplier' ,'exercise_id')
                ->toArray();

            $plan_exercises = [];
            foreach ($template_exercises as $exercise_id => $multiplier) {
                $plan_exercises[$exercise_id] = ['multiplier' => $multiplier];
            }

            $plan->exercises()->sync($plan_exercises);
        });

    }
}
