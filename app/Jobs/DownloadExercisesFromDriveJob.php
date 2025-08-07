<?php

namespace App\Jobs;

use App\Models\Exercise;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class DownloadExercisesFromDriveJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?int   $user,
        public string $file
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $imported_exercises = [];

        try {
            $imported_exercises = json_decode(Storage::disk('local')->get($this->file), true);

        }catch (\Exception $exception ){
            Log::error($exception->getMessage());
            Log::error("Couldn't import exercises");
        }





        foreach ($imported_exercises as $imported_exercise) {
            try {
                $exercise = Exercise::updateOrCreate([
                    'name' => $imported_exercise['name'],
                ],[
                    'description' => $imported_exercise['description'],
                    'unit' => $imported_exercise['unit'],
                    'user_id' => $this->user
                ]);

                //todo sync body parts

                $client = new \GuzzleHttp\Client();

                $media = ['images', 'videos'];

                $exercise_media = [
                    'images' => $imported_exercise['images'],
                    'videos' => $imported_exercise['videos'],
                ];

                foreach ($media as $item) {
                    if (array_key_exists($item, $imported_exercise)) {
                        foreach ($imported_exercise[$item] as $imported_media) {
                            $name = Arr::last(explode('/', $imported_media));

                            if (Storage::disk('exercises')->exists("/{$item}/{$name}")) {
                                continue;
                            }

                            try {
                                $response = $client->get($imported_media);
                                Storage::disk('exercises')->put("/{$item}/{$name}", $response->getBody()->getContents());
                            }catch (\Exception $e) {
                                Log::error("Failed to download {$item}: {$imported_media}");
                                Log::error($e->getMessage());
                                continue;
                            }
                        }

                        $exercise_media[$item][]="{$item}/{$name}";
                    }
                }



                $exercise->update([
                    'images' => $exercise_media['images'],
                    'videos' => $exercise_media['videos'],
                ]);


            }catch (\Throwable $throwable){
                Log::error($throwable->getMessage());
                Log::error("Couldn't import exercise: {$imported_exercise['name']}");
            }

        }


        Log::info("Exercises imported successfully");


        Storage::disk('local')->delete($this->file);


    }
}
