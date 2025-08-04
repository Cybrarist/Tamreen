<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Models\Exercise;
use App\Models\ExercisePlan;
use App\Models\ExercisePlanTemplate;
use App\Models\Item;
use App\Models\Type;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Auth::user()->role != UserRoleEnum::Admin , 403);
        $validated = request()->validate([
            'search' => ['nullable', 'string'],
        ]);

        $users = User::query();

        if(array_key_exists('search', $validated)){
            $users->whereAny(['name', 'email'], 'like', '%'.$validated['search'].'%');
        }

        return Inertia::render('users/indexUser' , [
            'users' =>  $users->orderBy('name')
                ->cursorPaginate(10)
                ->appends(request()->query()),
            'search' => $validated['search'] ?? null
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Auth::user()->role != UserRoleEnum::Admin , 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)]
        ]);


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => !User::exists() ?  UserRoleEnum::Admin : $request->role,
        ]);


        return back()
            ->with('message', 'User created successfully.')
            ->with('severity', 'success');
    }


    public function update(Request $request, User $user)
    {
        abort_if(Auth::user()->role != UserRoleEnum::Admin, 403);

        $validated=$request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|'.Rule::unique(User::class)->ignore($user->id),
            'password' => ['nullable', Password::defaults()],
            'role' => ['required', 'string', Rule::enum(UserRoleEnum::class)]
        ]);

        if (!$validated['password'])
            unset($validated['password']);

        $user->update($validated);

        return back()
            ->with('message', 'User updated successfully.')
            ->with('severity', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if(Auth::user()->role != UserRoleEnum::Admin, 403);

        DB::transaction(function () use ($user) {
            $user_workouts = $user->workouts()
                ->withoutGlobalScopes()
                ->pluck('id')->toArray();

            DB::table('exercise_workout')
                ->whereIn('workout_id', $user_workouts)
                ->delete();

            $user->workouts()
                ->withoutGlobalScopes()
                ->delete();


            $user_exercise_plans = ExercisePlan::where('user_id', $user->id)
                ->withoutGlobalScopes()
                ->pluck('id')->toArray();;

            DB::table('exercise_exercise_plan')
                ->whereIn('exercise_plan_id', $user_exercise_plans)
                ->delete();

            $user->exercise_plans()
                ->withoutGlobalScopes()
                ->delete();


            $user_exercise_plan_templates = $user->exercise_plan_templates()
                ->withoutGlobalScopes()
                ->pluck('id')->toArray();;

            DB::table('exercise_exercise_plan_template')
                ->whereIn('exercise_plan_template_id', $user_exercise_plan_templates)
                ->delete();


            $user->exercise_plan_templates()
                ->withoutGlobalScopes()
                ->delete();

            $user_exercises = $user->exercises()
                ->withoutGlobalScopes()
                ->pluck('id')->toArray();

            DB::table('body_part_exercise')
                ->whereIn('exercise_id', $user_exercises)
                ->delete();

            $user->exercises()
                ->withoutGlobalScopes()
                ->delete();

            $user->items()
                ->withoutGlobalScopes()
                ->delete();
            $user->types()
                ->withoutGlobalScopes()
                ->delete();

            $user->delete();
        });


        return back()
            ->with('message', 'User deleted successfully.')
            ->with('severity', 'success');
    }
}
