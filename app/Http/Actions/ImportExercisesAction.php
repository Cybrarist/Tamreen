<?php

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Jobs\DownloadExercisesFromDriveJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportExercisesAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'all_users' => ['required', 'boolean'],
            'file' => ['required', 'file', 'mimes:json'],
        ]);

        $path = $request->file('file')->store('temp');


        DownloadExercisesFromDriveJob::dispatch(($request->all_users) ? null : Auth::id(), $path);

        return back()
            ->with('message', 'Import started successfully.')
            ->with('severity', 'success');




        return response()->json(['message' => 'Exercises imported successfully']);
    }
}
