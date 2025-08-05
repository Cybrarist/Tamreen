<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemResource;
use App\Models\ExercisePlan;
use App\Models\Item;
use App\Models\Type;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ItemController extends Controller
{
    #
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validated = request()->validate([
            'search' => ['nullable', 'string'],
        ]);

        $items = Auth::user()->items();

        if(array_key_exists('search', $validated)){
            $items->where('name', 'like', '%'.$validated['search'].'%');
        }

        return Inertia::render('Dashboard' , [
            'items' =>  $items->orderBy('name')
                ->select(['id', 'name','image','type_id'])
                ->with('type:id,name')
                ->cursorPaginate(30)
                ->appends(request()->query()),
            'search' => $validated['search'] ?? null
        ]);

    }

    public function create()
    {
        $types = Type::all();
        return Inertia::render('items/createItem', [
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request)
    {
        $random_name = null;

        if($request->hasFile('image')){
            $random_name = Str::random(32) . "." .  $request->file('image')->extension();

            Storage::disk('items')
                ->put($random_name, file_get_contents($request->file('image')));
        }

        $item = Item::create(
            $request->safe(['name', 'description', 'type_id']) + [
                'image' => $random_name,
                'user_id' => Auth::id(),
            ]
        );

        return to_route('items.show', $item)
            ->with('message', 'Item created successfully.')
            ->with('severity', 'success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        Gate::authorize('view', $item);

        $item->load([
            'exercise_plans:id,name,item_id'=>[
                'exercises:id,name,images,videos'
            ]
        ]);

        return Inertia::render('items/showItem' , [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        Gate::authorize('update', $item);

        $types = Type::all();

        return Inertia::render('items/editItem' , [
            'item' => $item,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        Gate::authorize('update', $item);

        $file_name = $item->image;

        if($request->hasFile('image')){
            Storage::disk('items')->delete($item->image);

            $file_name = Str::random(32) . "." .  $request->file('image')->extension();

            Storage::disk('items')
                ->put($file_name, file_get_contents($request->file('image')));
        }

        $item = $item->update(
            $request->safe(['name', 'description', 'type_id']) + [
                'image' => $file_name,
            ]
        );

        return to_route('items.show', $item)
            ->with('message', 'Item updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        Gate::authorize('delete', $item);

        DB::transaction(function () use ($item) {

            $exercise_plans_for_item = ExercisePlan::where('item_id', $item->id)
                ->pluck('id')
                ->toArray();

            DB::table('exercise_exercise_plan')
                ->whereIn('plan_id', $exercise_plans_for_item)
                ->delete();

            $workouts_for_item = Workout::where('item_id', $item->id)
                ->pluck('id')
                ->toArray();

            DB::table('exercise_workout')
                ->whereIn('workout_id', $workouts_for_item)
                ->delete();

            Workout::whereIn('id', $workouts_for_item)
                ->delete();

            ExercisePlan::whereIn('id', $exercise_plans_for_item)
                ->delete();

            if ($item->image)
                Storage::disk('items')->delete($item->image);

            $item->delete();

        });

        return to_route('items.index')
            ->with('message', 'Item deleted successfully.')
            ->with('severity', 'success');
    }


}
