<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string'],
        ]);

        $types = Type::query();

        if(array_key_exists('search', $validated)){
            $types->where('name', 'like', '%'.$validated['search'].'%');
        }

        return Inertia::render('types/indexType' , [
            'types' =>  $types->orderBy('name')
                ->select(['id', 'name'])
                ->cursorPaginate(30)
                ->appends(request()->query()),
            'search' => $validated['search'] ?? null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('types/createType');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $type = Type::create($request->safe()->all() + [
            'user_id' => Auth::id()
        ]);

        return to_route('types.show', $type)
            ->with('message', 'Type created successfully.')
            ->with('severity', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return Inertia::render('types/editType', [
            'type' => $type,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $type->update($request->safe()->all());

        return back()->with('message', 'Type updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return to_route('types.index')
            ->with('message', 'Type deleted successfully.')
            ->with('severity', 'success');
    }
}
