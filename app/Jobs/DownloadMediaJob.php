<?php

namespace App\Jobs;

use App\Models\Exercise;
use GuzzleHttp\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadMediaJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $url,
        public string $path,
        public int $exercise_id,
        public string $disk,
        public string $field
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (Storage::disk($this->disk)->exists($this->path)) {
            return;
        }
        $client = new Client();

        try {
            $response = $client->get($this->url);
            Storage::disk($this->disk)->put($this->path, $response->getBody()->getContents());

            $exercise = Exercise::withoutGlobalScopes()->firstWhere('id', $this->exercise_id);

            $exercise->update([
                $this->field => [...$exercise->{$this->field}, $this->path]
            ]);

        }catch (\Exception $e) {
            Log::error("Failed to download {$this->url} for exercise {$this->exercise_id}");
            Log::error($e->getMessage());
        }
    }
}
