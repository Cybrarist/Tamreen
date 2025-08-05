<?php

namespace App\Http\Controllers;

use App\Enum\WorkoutStatusEnum;
use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\Workout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validated = request()->validate([
            'item_id' => ['nullable', 'integer'],
        ]);

        $query = Workout::query()
            ->whereIn('status', [
                WorkoutStatusEnum::InProgress,
            ]);

        if(request()->has('item_id'))
            $query->where('item_id', $validated['item_id']);

        $query->with([
                'item:id,name,image,type_id',
                'item.type:id,name',
                'exercises:id'
            ]);

        return Inertia::render('workouts/indexWorkout', [
            'workouts' =>$query->cursorPaginate(30)
                ->appends(request()->query()),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutRequest $request)
    {
        $workout = Workout::create($request->safe()->all() +[
            'user_id' => Auth::id(),
        ]);

        $exercises = DB::table('exercise_exercise_plan')
            ->where('exercise_exercise_plan.plan_id', $request->exercise_plan_id)
            ->get()
            ->map(fn($item) => [
                'exercise_id' => $item->exercise_id,
                'multiplier' => $item->multiplier,
                'metric' => $item->metric,
            ])
            ->keyBy('exercise_id')
            ->toArray();


        $workout->exercises()->sync($exercises);


        return to_route('workouts.show', $workout)
            ->with('message', 'Workout created successfully.')
            ->with('severity', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workout $workout)
    {
        $workout->load([
            'item',
            'exercises'
        ]);


        return Inertia::render(
            'workouts/showWorkout',
            [
                'workout' => $workout,
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkoutRequest $request, Workout $workout)
    {
        $validated = $request->validated();

        foreach ($validated['exercises'] as &$exercise) {
            $exercise['workout_id'] = $workout->id;
            $exercise['total'] = ceil($exercise['count'] * $exercise['multiplier']);
            $exercise['exercise_id'] = $exercise['id'];
        }

        DB::table('exercise_workout')
            ->where('workout_id', $workout->id)
            ->upsert(
                $validated['exercises'],
                ['exercise_id' , 'workout_id'],
                ['count' , 'total', 'completed']
            );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout)
    {
        Gate::authorize('delete', $workout);

        DB::transaction(function () use ($workout) {
            $workout->exercises()->detach();
            $workout->delete();
        });

        return to_route('workouts.index')
            ->with('message', 'Workout deleted successfully.')
            ->with('severity', 'success');
    }
}
