<?php

namespace App\Jobs;

use App\Notifications\CreateRecipeNotification;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;


class CreateRecipeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(UserRepository $userRepository): void
    {
        try {
            Log::info('Inside handle method of CreateRecipeNotificationJob');
            Log::info($this->data);

            if (!$userRepository) {
                Log::info('UserRepository is null');
            }

            $user = $userRepository->find($this->data);
            Notification::send($user, new CreateRecipeNotification());
            Log::info('sending email notification for creating new recipe with queues');

        } catch (\Exception $e) {
            Log::info("Unable to dispatch the queue. Reason: " . $e->getMessage());
        }
    }
}
