<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Models\ExercisePlan;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('settings/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return to_route('profile.edit');
    }

    /**
     * Delete the user's profile.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

//        Auth::logout();

        DB::transaction(function () use ($user) {
            $user_workouts = $user->workouts()->pluck('id')->toArray();

            DB::table('exercise_workout')
                ->whereIn('workout_id', $user_workouts)
                ->delete();

            $user->workouts()->delete();



            $user_exercise_plans = ExercisePlan::where('user_id', $user->id)->pluck('id')->toArray();;

            DB::table('exercise_exercise_plan')
                ->whereIn('plan_id', $user_exercise_plans)
                ->delete();

            $user->exercise_plans()->delete();
//

            $user_exercise_plan_templates = $user->exercise_plan_templates()->pluck('id')->toArray();;

            DB::table('exercise_exercise_plan_template')
                ->whereIn('template_id', $user_exercise_plan_templates)
                ->delete();


            $user->exercise_plan_templates()->delete();

            $user_exercises = $user->exercises()->pluck('id')->toArray();

            DB::table('body_part_exercise')
                ->whereIn('exercise_id', $user_exercises)
                ->delete();



            $user->exercises()->delete();


            $user->items()->delete();
            $user->types()->delete();

            $user->delete();
        });


        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
