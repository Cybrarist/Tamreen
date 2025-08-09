<?php

namespace App\Http\Actions;

use App\Http\Controllers\Controller;
use App\Jobs\DownloadExercisesFromDriveJob;
use App\Jobs\DownloadMediaJob;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportExercisesAction extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:json'],
        ]);

        $file = $request->file('file')->store('temp');


        $imported_exercises = [];

        try {
            $imported_exercises = json_decode(Storage::disk('local')->get($file), true);

        }catch (\Exception $exception ){
            Log::error($exception->getMessage());
            Log::error("Couldn't import exercises");
            Storage::disk('local')->delete($file);
        }


        foreach ($imported_exercises as $imported_exercise) {

            try {
                $exercise = Exercise::updateOrCreate(
                    [
                        'name' => $imported_exercise['name'],
                        'user_id' => Auth::id(),
                    ],
                    [
                        'description' => $imported_exercise['description'],
                        'unit' => $imported_exercise['unit'],
                    ]
                );


            }catch (\Exception $exception ){
                return back()
                    ->with('message', 'Import failed.')
                    ->with('severity', 'error');
            }

            $media_types = ['images', 'videos'];

            foreach ($media_types as $type) {
                if (array_key_exists($type, $imported_exercise)) {
                    foreach ($imported_exercise[$type] as $index=> $media) {
                        $name = Str::random(32) . '.' . pathinfo($media, PATHINFO_EXTENSION);

                        DownloadMediaJob::dispatch(
                            $media,
                            "{$type}/{$name}",
                            $exercise->id,
                            'exercises',
                            $type
                        )->delay(now()->addSeconds($index * 5));;
                    }
                }

            }

        }

        Storage::disk('local')->delete($file);

        return back()
            ->with('message', 'Import started successfully.')
            ->with('severity', 'success');

    }
}
