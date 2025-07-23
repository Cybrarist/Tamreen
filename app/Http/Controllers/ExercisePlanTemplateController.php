<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExercisePlanTemplateRequest;
use App\Http\Requests\UpdateExercisePlanTemplateRequest;
use App\Models\Exercise;
use App\Models\ExercisePlanTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExercisePlanTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ExercisePlanTemplates = ExercisePlanTemplate::all();

        return Inertia::render('templates/indexTemplate', [
            'templates' => $ExercisePlanTemplates,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exercises = Exercise::all();

        return Inertia::render('templates/createTemplate', [
            'exercises' => $exercises,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExercisePlanTemplateRequest $request)
    {
        $template = ExercisePlanTemplate::create($request->safe()->only(['name', 'description']) + [
                'user_id' => Auth::id()
            ]);

        $exercises_values = $request->safe()->only('exercises');
        $exercises = [];

        foreach ($exercises_values['exercises'] as $value) {
            $exercises[$value['exercise_id']] = ['multiplier' => $value['multiplier']];
        }

        $template->exercises()->sync($exercises);

        return to_route('templates.index')
            ->with('message', 'Template created successfully.')
            ->with('severity', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExercisePlanTemplate $template)
    {
        $template->load('exercises');
        $exercises = Exercise::all();



        return Inertia::render('templates/editTemplate', [
            'template' => $template,
            'exercises' => $exercises,

        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExercisePlanTemplateRequest $request, ExercisePlanTemplate $template)
    {

        $template->update($request->safe()->only(['name', 'description']));

        $exercises_values = $request->safe()->only('exercises');
        $exercises = [];

        foreach ($exercises_values['exercises'] as $value) {
            $exercises[$value['exercise_id']] = ['multiplier' => $value['multiplier']];
        }


        $template->exercises()->sync($exercises);


        return back()
            ->with('message', 'Plan updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExercisePlanTemplate $ExercisePlanTemplate)
    {
        //
    }

    public function filter(Request $request)
    {
        $templates = ExercisePlanTemplate::all();

        return $templates;

    }
}
