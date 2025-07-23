<?php

namespace App\Http\Controllers;

use App\Models\ExercisePlan;
use App\Models\Item;
use App\Models\Workout;
use Illuminate\Http\Request;

class CreateNewWorkoutForItem extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Item $item , ExercisePlan $plan)
    {

    }
}
