<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExercisePlanRequest;
use App\Http\Requests\UpdateExercisePlanRequest;
use App\Models\Exercise;
use App\Models\ExercisePlan;
use App\Models\Workout;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExercisePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exercisePlans = ExercisePlan::all();

        return Inertia::render('plans/indexPlan', [
            'plans' => $exercisePlans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercises = Exercise::all();

        return Inertia::render('plans/createPlan', [
            'exercises' => $exercises,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExercisePlanRequest $request)
    {

        $plan = ExercisePlan::create($request->safe()->only(['name', 'description']) + [
            'user_id' => Auth::id()
        ]);

        $exercises_values = $request->safe()->only('exercises');
        $exercises = [];

        foreach ($exercises_values['exercises'] as $value) {
            $exercises[$value['exercise_id']] = ['multiplier' => $value['multiplier']];
        }

        $plan->exercises()->sync($exercises);

        return redirect()->route('plans.index')
            ->with('message', 'Plan created successfully.')
            ->with('severity', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExercisePlan $plan)
    {
        $plan->load('exercises');
        $exercises = Exercise::all();


        return Inertia::render('plans/editPlan', [
            'plan' => $plan,
            'exercises' => $exercises,

        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExercisePlanRequest $request, ExercisePlan $plan)
    {
        $plan->update($request->safe()->only(['name', 'description']));

        $exercises_values = $request->safe()->only(['exercises']);
        $exercises = [];


        foreach ($exercises_values['exercises'] as $value) {
            $exercises[$value['exercise_id']] = [
                'multiplier' => $value['multiplier'],
                'metric' => $value['metric'],
            ];
        }

        $plan->exercises()->sync($exercises);


        return back()->with('message', 'Plan updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExercisePlan $plan)
    {
        $plan->exercises()->detach();

        Workout::where('exercise_plan_id', $plan->id)
            ->update(['exercise_plan_id' => null]);

        $plan->delete();

        return back()
            ->with('message', 'Plan deleted successfully.')
            ->with('severity', 'success');
    }
}
