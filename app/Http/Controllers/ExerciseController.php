<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\BodyPart;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
        ]);

        $body_parts = BodyPart::all();
        $exercises = Exercise::query();

        if(array_key_exists('search', $validated)){
            $exercises->where('name', 'like', '%'.$validated['search'].'%');
        }

        return Inertia::render('exercises/indexExercise' , [
            'exercises' =>  $exercises->orderBy('name')
                ->select(['id', 'name','images'])
                ->with('body_parts')
                ->cursorPaginate(30)
                ->appends(request()->query()),
            'search' => $validated['search'] ?? null,
            'body_parts' => $body_parts,

        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $body_parts = BodyPart::orderBy('name')->get();

        return Inertia::render('exercises/createExercise',
            [
                'body_parts' => $body_parts,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request)
    {
        $request->validated();

        $images = [];

        if ($request->hasFile('images') && sizeof($request->file('images')) > 0) {
            foreach ($request->file('images') as $image) {
                $uploaded= Storage::disk('exercises')->put('/images', $image);
                if ($uploaded) {
                    $images[] = $uploaded;
                }
            }
        }

        $videos = [];

        if ($request->hasFile('videos') && sizeof($request->file('videos')) > 0) {
            foreach ($request->file('videos') as $video) {
                $uploaded= Storage::disk('exercises')->put('/videos', $video);
                if ($uploaded) {
                    $videos[] = $uploaded;
                }
            }
        }

        $exercise = Exercise::create($request->safe()->except(['images','videos']) + [
                'images' => $images,
                'videos' => $videos,
                'user_id' => Auth::id(),
            ]);

        $exercise->body_parts()->sync($request->safe(['body_parts'])['body_parts'] ?? []);

        return to_route('exercises.show', $exercise->id)
            ->with('message', 'Exercise created successfully.')
            ->with('severity', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise)
    {
        $body_parts = BodyPart::orderBy('name')->get();

        $exercise->load('body_parts');

        return  Inertia::render('exercises/editExercise', [
            'exercise' => $exercise,
            'body_parts' => $body_parts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise)
    {


        $images = array_diff($exercise->images ?? [], $request->safe(['deleted_images'])['deleted_images'] ?? []);
        $videos = array_diff($exercise->videos ?? [], $request->safe(['deleted_videos'])['deleted_videos'] ?? []);

        if (sizeof($request->deleted_images ?? []) > 0)
            foreach ($request->safe(['deleted_images'])['deleted_images'] as $image) {
                Storage::disk('exercises')->delete($image);
            }

        if (sizeof($request->deleted_videos ?? []) > 0)
            foreach ($request->safe(['deleted_videos'])['deleted_videos'] as $video) {
                Storage::disk('exercises')->delete($video);
            }

        if ($request->hasFile('images') && sizeof($request->file('images')) > 0) {
            foreach ($request->file('images') as $image) {
                $uploaded= Storage::disk('exercises')
                    ->put('/images', $image);
                if ($uploaded) {
                    $images[] = $uploaded;
                }
            }
        }

        if ($request->hasFile('videos') && sizeof($request->file('videos')) > 0) {
            foreach ($request->file('videos') as $video) {
                $uploaded= Storage::disk('exercises')
                    ->put('/videos', $video);

                if ($uploaded) {
                    $videos[] = $uploaded;
                }
            }
        }


        $exercise->update($request->safe([
            'name',
            'description',
        ]) + [
            'images' => $images,
            'videos' => $videos,
        ]);

        $exercise->body_parts()->sync($request->safe(['body_parts'])['body_parts'] ?? []);


        return to_route('exercises.show', $exercise->id)
            ->with('message', 'Exercise updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise)
    {
        //
    }


    public function filter(Request $request)
    {
        $exercises = Exercise::all();

        return $exercises;
    }
}
