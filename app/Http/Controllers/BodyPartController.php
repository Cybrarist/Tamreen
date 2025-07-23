<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBodyPartRequest;
use App\Http\Requests\UpdateBodyPartRequest;
use App\Models\BodyPart;
use Inertia\Inertia;

class BodyPartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bodyParts = BodyPart::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBodyPartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BodyPart $bodyPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BodyPart $bodyPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBodyPartRequest $request, BodyPart $bodyPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BodyPart $bodyPart)
    {
        //
    }
}
