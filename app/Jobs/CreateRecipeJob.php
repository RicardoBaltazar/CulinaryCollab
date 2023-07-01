<?php

namespace App\Jobs;

use App\Repositories\RecipeRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateRecipeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(RecipeRepository $recipeRepository): void
    {
        try {
            Log::info('Inside handle method');
            Log::info($this->data);

            if (!$recipeRepository) {
                Log::info('RecipeRepository is null');
                return;
            }

            $recipeRepository->create($this->data);
            Log::info('Creating new recipe with queue');
        } catch (\Exception $e) {
            Log::info("Unable to dispatch the queue. Reason: " . $e->getMessage());
        }
    }
}
