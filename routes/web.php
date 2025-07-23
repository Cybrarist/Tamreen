<?php


use App\Http\Actions\CloneTemplateToExerciseAction;
use App\Http\Controllers\BodyPartController;
use App\Http\Controllers\CreateNewWorkoutForItem;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExercisePlanController;
use App\Http\Controllers\ExercisePlanTemplateController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WorkoutController;

Route::middleware('auth')
    ->group(function () {

        Route::get('/', [ItemController::class , 'index'])->name('dashboard');
        Route::get('/items/search', [ItemController::class, 'search'])->name('items.search');
        Route::resource('items', ItemController::class);
        Route::resource('types', TypeController::class);

        Route::get('/plans/templates/filter', [ ExercisePlanTemplateController::class, 'filter'])->name('templates.filter');
        Route::resource('/plans/templates', ExercisePlanTemplateController::class);
        Route::resource('plans', ExercisePlanController::class);
        Route::get('exercises/filter', [ExerciseController::class , 'filter'])->name('exercises.filter');
        Route::resource('exercises', ExerciseController::class);
        Route::resource('body-parts', BodyPartController::class);


        Route::get('/templates/{template}/{item}/clone', CloneTemplateToExerciseAction::class)->name('templates.clone');
        Route::delete('/plans/{plan}/delete', [ExercisePlanController::class, 'destroy'])->name('plans.delete');
        Route::resource('workouts', WorkoutController::class);
    });


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
